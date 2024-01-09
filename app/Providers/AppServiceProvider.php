<?php

namespace App\Providers;

use App\Repositories\Surveys\EloquentSurveyRepository;
use App\Repositories\Surveys\SurveyRepositoryInterface;
use App\Repositories\Users\EloquentUserRepository;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(SurveyRepositoryInterface::class, EloquentSurveyRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
