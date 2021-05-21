<?php

namespace App\Providers;

use App\Models\Widget;
use App\Observers\WidgetObserver;
use Illuminate\Support\ServiceProvider;

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
        Widget::observe(WidgetObserver::class);
    }
}
