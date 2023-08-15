<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Track;

use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\Image;
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
                            ->required()
                    ])
                ])->columnSpan(4),
                Column::make([
                    Block::make([
                        Text::make('Name', 'name')
                            ->required()
                            ->sortable()
                    ])
                ])->columnSpan(8)
            ])
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
