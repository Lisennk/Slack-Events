<?php

namespace Lisennk\LaravelSlackEventsApi;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Lisennk\LaravelSlackEvents\EventCreator;
use Illuminate\Support\Facades\Event;

class SlackApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request, EventCreator $events)
    {
        $event = $events->make($request->input('event.type'));

        $event->api_app_id = $request->input('api_app_id');
        $event->event = (object) $request->input('event');
        $event->authed_users = (array) $request->input('authed_users');
        $event->event_ts = $request->input('event_ts');
        $event->team_id = $request->input('team_id');
        $event->token = $request->input('token');
        $event->type = $request->input('type');
        $event->user = $request->input('user');

        Event::fire($event);
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