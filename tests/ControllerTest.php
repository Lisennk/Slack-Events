<?php

namespace Lisennk\LaravelSlackEvents\Tests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Lisennk\LaravelSlackEvents\EventCreator;
use Lisennk\LaravelSlackEvents\Events\ReactionAdded;
use Lisennk\LaravelSlackEvents\Http\EventController;
use Lisennk\LaravelSlackEvents\Tests\Traits\EventRequestDataTrait;
use Orchestra\Testbench\TestCase;

/**
 * Tests EventController
 */
class ControllerTest extends TestCase
{
    use EventRequestDataTrait;

    /**
     * Tests event firing
     */
    public function testFire()
    {
        Event::fake();

        $controller = new EventController();

        $request = new Request;
        $request->replace($this->eventRequestData);
        $creator = new EventCreator();

        $response = $controller->fire($request, $creator);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status());

        Event::assertDispatched(ReactionAdded::class);
    }
}