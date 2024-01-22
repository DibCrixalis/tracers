<?php

namespace App\Providers;


use App\Repositories\ContinueStudy\ContinueStudyRepositoryInterface;
use App\Repositories\ContinueStudy\EloquentContinueStudyRepository;
use App\Repositories\Entrepreneurship\EloquentEntrepreneurshipRepository;
use App\Repositories\Entrepreneurship\EntrepreneurshipRepositoryInterface;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Work\EloquentWorkRepository;
use App\Repositories\Work\WorkRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(ContinueStudyRepositoryInterface::class, EloquentContinueStudyRepository::class);
        $this->app->bind(WorkRepositoryInterface::class, EloquentWorkRepository::class);
        $this->app->bind(EntrepreneurshipRepositoryInterface::class, EloquentEntrepreneurshipRepository::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
