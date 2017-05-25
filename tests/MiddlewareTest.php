<?php

namespace Lisennk\LaravelSlackEvents\Tests;

use Illuminate\Http\Response;
use Orchestra\Testbench\TestCase;
use Lisennk\LaravelSlackEvents\Tests\Traits\EventRequestDataTrait;
use Illuminate\Http\Request;
use \Lisennk\LaravelSlackEvents\Http\EventMiddleware;
use \Lisennk\LaravelSlackEvents\SlackEventsServiceProvider;

/**
 * Tests EventMiddleware
 */
class MiddlewareTest extends TestCase
{
    use EventRequestDataTrait;

    /**
     * Test for wrong token check
     */
    public function testWrongToken()
    {
        $data = array_merge($this->eventRequestData, [
            'token' => 'wrong-token'
        ]);

        $request = new Request();
        $request->replace($data);

        $middleware = new EventMiddleware;
        $response = $middleware->handle($request, function($response) {});

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals('Wrong token', $response->content());
    }

    /**
     * Middleware shouldn't react on correct request
     */
    public function testMiddlewarePass()
    {
        $request = new Request();
        $request->replace($this->eventRequestData);
        $middleware = new EventMiddleware;

        $middleware->handle($request, function($request) {
            $this->assertInstanceOf(Request::class, $request);
        });
    }

    /**
     * Test for url verification
     */
    public function testUrlVerification()
    {
        $data = [
            'token' => $this->eventRequestData['token'],
            'challenge' => 'challenge-code',
            'type' => 'url_verification'
        ];

        $request = new Request();
        $request->replace($data);

        $middleware = new EventMiddleware;
        $response = $middleware->handle($request, function($response) {});

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status());
        $this->assertEquals($data['challenge'], $response->content());
    }

    /**
     * Load service provider
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [SlackEventsServiceProvider::class];
    }

    /**
     * Set environment variables
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('slackEvents.token', $this->eventRequestData['token']);
    }
}