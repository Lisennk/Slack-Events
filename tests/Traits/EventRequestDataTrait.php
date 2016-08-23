<?php

namespace Lisennk\LaravelSlackEvents\Tests\Traits;

/**
 * Example of Slack Event Request data
 */
trait EventRequestDataTrait
{
    /**
     * @var array
     */
    public $eventRequestData = [
        'token' => 'your-validation-token-here',
        'team_id' => 'team-id',
        'api_app_id' => 'app-id',
        'event' => [
            'type' => 'reaction_added',
            'user' => 'user-id',
            'item' => [
                'type' => 'message',
                'channel' => 'channel-id',
                'ts' => '1464196127.000002'
            ],
            'reaction' => 'slightly_smiling_face'
        ],
        'event_ts' => '1465244570.336841',
        'type' => 'event_callback',
        'authed_users'=> [
            'authed-user-id'
        ]
    ];
}