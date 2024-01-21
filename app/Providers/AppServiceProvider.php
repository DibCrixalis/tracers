<?php

namespace App\Providers;

use App\Repositories\Company\CompanyRepositoryInterface;
use App\Repositories\Company\EloquentCompanyRepository;
use App\Repositories\Perusahaan\EloquentPerusahaanRepository;
use App\Repositories\Perusahaan\PerusahaanRepositoryInterface;

use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, EloquentCompanyRepository::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
