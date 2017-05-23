<?php

return [
    /*
    |-------------------------------------------------------------
    | Your validation token from "App Credentials"
    |-------------------------------------------------------------
    */
    'token' => env('SLACK_EVENT_TOKEN', 'your-validation-token-here'),

    /*
    |-------------------------------------------------------------
    | Events Request URL — path, where events will be served
    |-------------------------------------------------------------
    */
    'route' => '/api/slack/event/fire',

];
