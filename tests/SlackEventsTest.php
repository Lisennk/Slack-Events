<?php

use PHPUnit\Framework\TestCase;
use \Lisennk\LaravelSlackEvents\EventCreator;
use \Lisennk\LaravelSlackEvents\Events\ReactionAdded;
use \Lisennk\LaravelSlackEvents\Events\ChannelCreated;

/**
 * Class SlackEventsTest
 */
class SlackEventsTest extends TestCase
{
    /**
     * @var array example of slack event request, can be used also for integration testing
     */
    public $data = [
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
                'U061F7AUR'
        ]
    ];

    /**
     * Test for proper event class from event type creation
     */
    public function testShouldCreateReactionAdded()
    {
        $events = new EventCreator();

        $event = $events->make('reaction_added');
        $this->assertTrue($event instanceof ReactionAdded);
    }

    /**
     * Test for proper event class from event type creation
     */
    public function testShouldCreateChannelCreated()
    {
        $events = new EventCreator();

        $event = $events->make('channel_created');
        $this->assertTrue($event instanceof ChannelCreated);
    }

    /**
     * Test for parameters passing
     */
    public function testSetFromArray()
    {
        $data = array_merge($this->data, [
            'token' => 'some-custom-token'
        ]);

        $events = new EventCreator();
        $event = $events->make($this->data['event']['type']);
        $event->setFromArray($data);

        $this->assertEquals($data['token'], $event->token);
        $this->assertEquals($data['event'], $event->event);
    }

}