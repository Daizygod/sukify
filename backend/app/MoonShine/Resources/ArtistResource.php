<?php

namespace App\MoonShine\Resources;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;

use Illuminate\Http\UploadedFile;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\HasMany;
use MoonShine\Fields\Image;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class ArtistResource extends Resource
{
	public static string $model = Artist::class;

	public static string $title = 'Artists';

    public string $titleField = 'name';

    public static int $itemsPerPage = 5;

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    protected bool $showInModal = true;

    public static array $with = [
        'tracks'
    ];

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),

            Text::make('Name', 'name')
                ->required()
                ->sortable()
                ->locked(),

            Image::make('Avatar', 'avatar')
                ->dir('/')
                ->disk('public')
                ->allowedExtensions(['jpg', 'png'])
                ->customName(fn(UploadedFile $file) =>  "images" . Carbon::now()->format('Ym') . '/' . $file->hashName()),

            Image::make('Background', 'background')
                ->dir('/')
                ->disk('public')
                ->allowedExtensions(['jpg', 'png'])
                ->customName(fn(UploadedFile $file) =>  "images" . Carbon::now()->format('Ym') . '/' . $file->hashName()),

            BelongsToMany::make('Tracks', 'tracks')
                ->hideOnIndex()
                ->hideOnForm()
//                ->canBeResourceMode()
//                ->resourceMode()
//                ->fields([
//                    ID::make(),
//                    BelongsTo::make('Name', 'name'),
//                ])
//            HasMany::make('Tracks', 'tracks')
//                ->fields([
//                    ID::make(),
//                    BelongsTo::make('Name', 'name'),
//                ])
//                ->hideOnForm()
//                ->hideOnIndex()
//                ->hideOnIndex()
//                ->resourceMode()
        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['name'];
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
