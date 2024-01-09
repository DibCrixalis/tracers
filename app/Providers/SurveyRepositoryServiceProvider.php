<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Surveys\EloquentSurveyRepository;
use App\Repositories\Surveys\SurveyRepositoryInterface;

class SurveyRepositoryServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
