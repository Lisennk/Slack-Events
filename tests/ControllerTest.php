<?php

namespace Lisennk\LaravelSlackEvents\Tests;

use Illuminate\Http\Response;
use Lisennk\LaravelSlackEvents\EventCreator;
use Orchestra\Testbench\TestCase;
use Lisennk\LaravelSlackEvents\Tests\Traits\EventRequestDataTrait;
use \Lisennk\LaravelSlackEvents\Http\EventController;
use Illuminate\Http\Request;

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
        $controller = new EventController();

        $request = new Request;
        $request->replace($this->eventRequestData);
        $creator = new EventCreator();

        $response = $controller->fire($request, $creator);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status());
    }
}