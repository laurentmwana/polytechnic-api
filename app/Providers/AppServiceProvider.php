<?php

namespace App\Providers;

use App\Models\ActualLevel;
use App\Models\Department;
use App\Observers\ActualLevelObserver;
use App\Observers\DepartmentObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ActualLevel::observe(new ActualLevelObserver());
        Department::observe(new DepartmentObserver());
    }
}
