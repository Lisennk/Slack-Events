<?php

use Orchestra\Testbench\TestCase;
use Illuminate\Http\Request;
use \Lisennk\LaravelSlackEvents\Http\EventMiddleware;
use \Lisennk\LaravelSlackEvents\SlackEventsServiceProvider;

/**
 * Class SlackEventsTest
 */
class MiddlewareTest extends TestCase
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
     * Test for wrong token check
     */
    public function testWrongToken()
    {
        $data = array_merge($this->data, [
            'token' => 'wrong-token'
        ]);

        $request = new Request();
        $request->replace($data);

        $middleware = new EventMiddleware;
        $response = $middleware->handle($request, function($response) {});

        $this->assertEquals(200, $response->status());
        $this->assertEquals('Wrong token', $response->content());
    }

    /**
     * Middleware shouldn't react on correct request
     */
    public function testMiddlewarePass()
    {
        $request = new Request();
        $request->replace($this->data);
        $middleware = new EventMiddleware;

        $response = $middleware->handle($request, function($request) {
            $this->assertTrue($request instanceof Request);
        });
    }

    /**
     * Test for url verification
     */
    public function testUrlVerification()
    {
        $data = [
            'token' => $this->data['token'],
            'challenge' => 'challenge-code',
            'type' => 'url_verification'
        ];

        $request = new Request();
        $request->replace($data);

        $middleware = new EventMiddleware;
        $response = $middleware->handle($request, function($response) {});

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
        $app['config']->set('slackEvents.token', $this->data['token']);
    }
}