<?php

namespace Lisennk\LaravelSlackEvents\Http;

use Closure;
use Illuminate\Http\Request;

/**
 * Event validation
 *
 * @package Lisennk\LaravelSlackEvents\Http
 */
class EventMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->input('token') != config('slackEvents.token'))
            return response('Wrong token', 200);
        if ($request->input('type') == 'url_verification')
            return response($request->input('challenge'), 200);

        return $next($request);
    }
}
