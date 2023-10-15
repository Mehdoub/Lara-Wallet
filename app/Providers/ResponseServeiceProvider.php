<?php

namespace App\Providers;

use App\Services\Response\ResponseService;
use Illuminate\Support\ServiceProvider;

class ResponseServeiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('response', function () {
            return new ResponseService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
