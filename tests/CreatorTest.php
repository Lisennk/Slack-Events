<?php

namespace Lisennk\LaravelSlackEvents\Tests;

use Orchestra\Testbench\TestCase;
use Lisennk\LaravelSlackEvents\Tests\Traits\EventRequestDataTrait;
use \Lisennk\LaravelSlackEvents\EventCreator;
use \Lisennk\LaravelSlackEvents\Events\ReactionAdded;
use \Lisennk\LaravelSlackEvents\Events\ChannelCreated;
use \Illuminate\Http\Request;

/**
 * Tests EventCreator
 */
class SlackEventsTest extends TestCase
{
    use EventRequestDataTrait;

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
     * Test for parameters passing from array
     */
    public function testSetFromArray()
    {
        $data = array_merge($this->eventRequestData, [
            'token' => 'some-custom-token'
        ]);

        $events = new EventCreator();
        $event = $events->make($this->eventRequestData['event']['type']);
        $event->setFromArray($data);

        $this->assertEquals($data['token'], $event->token);
        $this->assertEquals($data['event'], $event->event);
    }

    /**
     * Test for parameters passing from http request
     */
    public function testSetFromRequest()
    {
        $data = array_merge($this->eventRequestData, [
            'token' => 'some-custom-token'
        ]);

        $request = new Request;
        $request->replace($data);

        $events = new EventCreator();
        $event = $events->make($this->eventRequestData['event']['type']);
        $event->setFromRequest($request);

        $this->assertEquals($data['token'], $event->token);
        $this->assertEquals($data['event'], $event->event);
    }
}