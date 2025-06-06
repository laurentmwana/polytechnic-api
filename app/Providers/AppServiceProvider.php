<?php

namespace App\Providers;

use App\Models\ActualLevel;
use App\Models\FeesAcademic;
use App\Models\FeesLaboratory;
use App\Observers\ActualLevelObserver;
use App\Observers\FeesAcademicObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\FeesLaboratoryObserver;

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
        ActualLevel::observe(new ActualLevelObserver());
        FeesAcademic::observe(new FeesAcademicObserver());
        FeesLaboratory::observe(new FeesLaboratoryObserver());
    }
}
