<?php

namespace App\Providers;


use App\Models\Transfer;
use App\Observers\TransferObserver;
use Illuminate\Support\ServiceProvider;

class ObserversServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Transfer::observe(TransferObserver::class);
    }
}
