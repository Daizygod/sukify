<?php

namespace App\MoonShine\Resources;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Track;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic;
use MoonShine\Decorations\Block;
use MoonShine\Decorations\Column;
use MoonShine\Decorations\Grid;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Color;
use MoonShine\Fields\Date;
use MoonShine\Fields\File;
use MoonShine\Fields\HasOne;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\Select;
use MoonShine\Fields\StackFields;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Filters\BelongsToManyFilter;
use MoonShine\Filters\SelectFilter;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class TrackResource extends Resource
{
	public static string $model = Track::class;

	public static string $title = 'Tracks';

    public string $titleField = 'name';

    public static int $itemsPerPage = 5;

    protected bool $createInModal = true;

    protected bool $editInModal = true;

    protected bool $showInModal = true;

    public static array $with = [
        'artists'
    ];//TODO - 112 remove


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
                            ->removable()
                            ->customName(fn(UploadedFile $file) =>  "images" . Carbon::now()->format('Ym') . '/' . $file->hashName()),
                        Color::make('Color', 'color')
                            ->hideOnIndex(),
                        File::make('Audio', 'file')
                            ->dir('/')
                            ->disk('public')
                            ->allowedExtensions(['mp3', 'wav'])
                            ->hideOnIndex()
//                            ->required()
                            ->removable()
                            ->customName(fn(UploadedFile $file) =>  "music" . Carbon::now()->format('Ym') . '/' . $file->hashName()),
                        Number::make('Duration', 'duration')
                            ->min(1)
                            ->max(600)
                            ->hideOnIndex()
                            ->hideOnDetail(),
                        File::make('Video', 'video_file')
                            ->dir('/')
                            ->disk('public')
                            ->allowedExtensions(['mp4'])
                            ->hideOnIndex()
                            ->removable()
                            ->customName(fn(UploadedFile $file) =>  "videos" . Carbon::now()->format('Ym') . '/' . $file->hashName())
                    ])
                ])->columnSpan(4),
                Column::make([
                    Block::make([
                        Text::make('Name', 'name')
                            ->required()
                            ->sortable()
                            ->locked()
                            ->hideOnIndex()
                    ]),

                    StackFields::make('Title')->fields([
                        Text::make('Name', 'name'),
                        BelongsToMany::make('Artists', 'artists', 'name')->inLine(separator: ' ', badge: true),
                    ])->hideOnForm()->hideOnDetail(),
                ])->columnSpan(8)
            ]),

            BelongsToMany::make('Artists', 'artists', 'name')
                ->asyncSearch()
                ->select()
                ->inLine(separator: ' ', badge: true)
                ->hideOnIndex(),

//            BelongsTo::make('Albums', 'albums', 'name')
//                ->asyncSearch()
////                ->select()
////                ->inLine(separator: ' ', badge: true)
//                ->hideOnIndex(),
//            BelongsToMany::make('Albums', 'albums', 'name')
//                ->asyncSearch()
//                ->fields([
//                    Text::make('Position', 'position'),
//                ])
//                ->hideOnIndex(),
            BelongsTo::make('Album', 'album', 'name')
                ->asyncSearch()
                ->hideOnIndex(),

            SwitchBoolean::make('Single', 'single'),

            Text::make('Duration', resource: function ($item) {
                $date = Carbon::now('UTC')->startOfDay()->addSeconds($item->duration);
                return $date->format('i:s');
            })->hideOnForm(),

            Number::make('Streams', 'counter')
                ->hideOnForm(),

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
        return ['name'];
    }

    public function filters(): array
    {
        return [
            BelongsToManyFilter::make('Artists', 'artists', 'name')
                ->select()
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }

//    protected function beforeCreating(Track $item)
//    {
//
//    }

//    protected function afterCreated(Track $item)
//    {
//        Log::info(json_encode($item));
//        // Событие после добавления записи
//    }

//    protected function beforeUpdating(Model $item)
//    {
//        // Событие перед обновлением записи
//    }
}
