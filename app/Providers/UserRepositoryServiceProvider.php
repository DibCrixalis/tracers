<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Users\EloquentUserRepository;
use App\Repositories\Users\UserRepositoryInterface;

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
