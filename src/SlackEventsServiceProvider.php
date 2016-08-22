<?php

namespace Lisennk\LaravelSlackEvents;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Lisennk\LaravelSlackEvents\EventCreator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

/**
 * Class SlackApiServiceProvider
 * @package Lisennk\LaravelSlackEventsApi
 */
class SlackEventsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $this->publishes([
            dirname(__FILE__).'/config/slackEvents.php' => config_path('slackEvents.php'),
        ]);

        if (!$this->app->routesAreCached()) {
            require dirname(__FILE__).'/Http/routes.php';
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
