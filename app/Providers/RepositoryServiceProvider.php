<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bind the interface to the implementation repository class
     */
    public function register()
    {
        $this->app->bind("App\Repositories\Auth\AuthRepository", "App\Repositories\Auth\AuthService");
        $this->app->bind("App\Repositories\User\UserRepository", "App\Repositories\User\UserService");
    }
}