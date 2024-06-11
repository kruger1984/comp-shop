<?php

namespace App\Providers;

use App\Menu\Menu;
use App\Menu\MenuItem;
use App\View\Composers\NavigationComposers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        Vite::macro('image', fn($asset)=> $this->asset("resources/images/$asset"));
        //TODO скорее всего лишнее
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Vite::macro('image', fn($asset) => $this->asset("resources/images/$asset"));

        View::composer('*', NavigationComposers::class);
    }
}
