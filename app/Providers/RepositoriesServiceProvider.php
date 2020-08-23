<?php

namespace App\Providers;


use App\Repositories\Contracts\TransferAuthorizationRepositoryContract;
use App\Repositories\Contracts\TransferRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Eloquent\TransferAuthorizationRepository;
use App\Repositories\Eloquent\TransferRepository;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(TransferRepositoryContract::class,TransferRepository::class);
        $this->app->bind(TransferAuthorizationRepositoryContract::class,TransferAuthorizationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
