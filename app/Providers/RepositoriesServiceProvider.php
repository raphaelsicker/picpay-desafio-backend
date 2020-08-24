<?php

namespace App\Providers;


use App\Repositories\Contracts\NotificationRepositoryContract;
use App\Repositories\Contracts\NotificationSenderRepositoryContract;
use App\Repositories\Contracts\TransferAuthorizationRepositoryContract;
use App\Repositories\Contracts\TransferRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Repositories\Eloquent\NotificationRepository;
use App\Repositories\Eloquent\NotificationSenderRepository;
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

        $this->app->bind(NotificationRepositoryContract::class,NotificationRepository::class);
        $this->app->bind(NotificationSenderRepositoryContract::class,NotificationSenderRepository::class);
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
