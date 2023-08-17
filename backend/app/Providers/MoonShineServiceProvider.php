<?php

namespace App\Providers;

use App\Models\Artist;
use App\Models\Track;
use App\MoonShine\Resources\ArtistResource;
use App\MoonShine\Resources\TrackResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([
            MenuGroup::make('moonshine::ui.resource.system', [
                MenuItem::make('moonshine::ui.resource.admins_title', new MoonShineUserResource())
                    ->translatable()
                    ->icon('users'),
                MenuItem::make('moonshine::ui.resource.role_title', new MoonShineUserRoleResource())
                    ->translatable()
                    ->icon('bookmark'),
            ])->translatable(),

            MenuGroup::make('Music', [
                MenuItem::make('Tracks', new TrackResource())
                    ->icon("heroicons.musical-note")
                    ->badge(fn() => Track::all()->count()),
                MenuItem::make('Artists', new ArtistResource())
                    ->icon("heroicons.microphone")
                    ->badge(fn() => Artist::all()->count())
            ])->icon("heroicons.outline.microphone"),

            MenuItem::make('Documentation', 'https://laravel.com')
                ->badge(fn() => 'Check'),
        ]);
    }
}
