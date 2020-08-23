<?php

namespace App\Providers;


use App\Services\Applications\TransferAuthorizerService;
use App\Services\Applications\TransferService;
use App\Services\Applications\UserService;
use App\Services\Applications\UserTransferService;
use App\Services\Contracts\TransferAuthorizerServiceContract;
use App\Services\Contracts\TransferServiceContract;
use App\Services\Contracts\UserServiceContract;
use App\Services\Contracts\UserTransferServiceContract;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(TransferServiceContract::class,TransferService::class);
        $this->app->bind(TransferAuthorizerServiceContract::class,TransferAuthorizerService::class);
        $this->app->bind(UserTransferServiceContract::class,UserTransferService::class);
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
