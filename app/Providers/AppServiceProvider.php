<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Service;
use App\Models\Units;
use App\Observers\CategoryObserver;
use App\Observers\ServiceObserver;
use App\Observers\UnitObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Category::observe(CategoryObserver::class);
        Service::observe(ServiceObserver::class);
        Units::observe(UnitObserver::class);
    }
}
