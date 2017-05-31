<?php

namespace Lisennk\LaravelSlackEvents\Events\Base;

use Illuminate\Http\Request;

/**
 * Slack Events API event
 * Fields the same as in Slack reuqest
 * @see https://api.slack.com/events-api#receiving_events
 * @package Lisennk\LaravelSlackEvents\Events
 */
class SlackEvent
{
    /**
     * @var string Verification token
     */
    public $token;

    /**
     * @var string The unique identifier for the team where this event occurred.
     */
    public $team_id;

    /**
     * @var string 	The unique identifier for the application this event is intended for.
     */
    public $api_app_id;

    /**
     * @var array Contains the inner set of fields representing the event that's happening.
     */
    public $event;

    /**
     * @var array Alias for $event
     */
    public $data;

    /**
     * @var string This reflects the type of callback you're receiving.
     */
    public $type;

    /**
     * @var array An array of string-based User IDs.
     */
    public $authed_users;

    /**
     * Sets parameters from request
     *
     * @param Request $request
     */
    public function setFromRequest(Request $request)
    {
        $this->setFromArray($request->all());
    }

    /**
     * Sets parameters from array
     *
     * @param array $data
     */
    public function setFromArray(array $data)
    {
        $this->api_app_id = $data['api_app_id'];
        $this->event = $data['event'];
        $this->data = $this->event;
        $this->authed_users = $data['authed_users'];
        $this->team_id = $data['team_id'];
        $this->token = $data['token'];
        $this->type = $data['type'];
    }
}
