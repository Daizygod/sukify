<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Reliese\Coders\Model\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        \Illuminate\Database\Eloquent\Model::preventLazyLoading(!app()->isProduction()); //TODO - 112 remove
    }
}
