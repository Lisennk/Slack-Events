<?php

namespace Lisennk\LaravelSlackEvents\Events\Base;

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
     * @var string The unique identifier of user that triggered event
     */
    public $user;

    /**
     * @var string 	The unique identifier for the application this event is intended for.
     */
    public $api_app_id;

    /**
     * @var object Contains the inner set of fields representing the event that's happening.
     */
    public $event;

    /**
     * @var string This reflects the type of callback you're receiving.
     */
    public $type;

    /**
     * @var string The timestamp of the event.
     */
    public $event_ts;

    /**
     * @var array An array of string-based User IDs.
     */
    public $authed_users;
}