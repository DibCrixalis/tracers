<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryInterface;

class UserRepositoryServiceProvider extends ServiceProvider
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
