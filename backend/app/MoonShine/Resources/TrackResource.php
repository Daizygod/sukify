<?php

namespace App\MoonShine\Resources;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Track;

use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Date;
use MoonShine\Fields\Image;
use MoonShine\Fields\Select;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class TrackResource extends Resource
{
	public static string $model = Track::class;

	public static string $title = 'Tracks';

	public function fields(): array
    {
        return [
            ID::make()->sortable(),

            Grid::make([
                Column::make([
                    Block::make([
                        Image::make('Cover', 'cover_file')
                            ->dir('/')
                            ->disk('public')
                            ->allowedExtensions(['jpg', 'png'])
//                            ->required()
                    ])
                ])->columnSpan(4),
                Column::make([
                    Block::make([
                        Text::make('Name', 'name')
                            ->required()
                            ->sortable()
                    ])
                ])->columnSpan(8)
            ]),

            BelongsToMany::make('Artists', 'artists', 'name')
                ->asyncSearch()
                ->select()
                ->inLine(separator: ' ', badge: true),

            Date::make('Release date', 'release_date')
                ->format('d.m.Y'),

            Date::make('Updated at', resource: function ($item) {
                return Carbon::createFromTimestamp($item->updated_at);//->format('H:i:s d.m.Y');
            })
                ->hideOnIndex()
                ->hideOnForm()
                ->readonly()
//                ->requestValue(Carbon::now('UTC')->timestamp)
                ->format('H:i:s d.m.Y')
        ];
    }

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
