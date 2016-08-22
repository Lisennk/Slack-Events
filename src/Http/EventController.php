<?php

namespace Lisennk\LaravelSlackEvents\Http;

use Illuminate\Http\Request;
use \Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Lisennk\LaravelSlackEvents\EventCreator;
use Lisennk\LaravelSlackEvents\Events\Base\SlackEvent;
use Lisennk\LaravelSlackEvents\Http\EventMiddleware;

/**
 * Class EventController
 *
 * @package Lisennk\LaravelSlackEvents
 */
class EventController extends Controller
{
    /**
     * EventController constructor.
     */
    public function __construct()
    {
        $this->middleware(EventMiddleware::class);
    }

    /**
     * Fire slack event
     *
     * @param Request $request
     * @param EventCreator $events
     * @return SlackEvent
     */
    public function fire(Request $request, EventCreator $events)
    {
        $event = $events->make($request->input('event.type'));
        $event->setFromRequest($request);
        Event::fire($event);

        return response('Event received', 200);
    }
}
