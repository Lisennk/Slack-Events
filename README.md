# :bell: Slack Events API for Laravel :bell:
[![Latest Stable Version](https://poser.pugx.org/lisennk/laravel-slack-events-api/v/stable)](https://packagist.org/packages/lisennk/laravel-slack-events-api)
[![Total Downloads](https://poser.pugx.org/lisennk/laravel-slack-events-api/downloads)](https://packagist.org/packages/lisennk/laravel-slack-events-api)
[![License](https://poser.pugx.org/lisennk/laravel-slack-events-api/license)](https://packagist.org/packages/lisennk/laravel-slack-events-api)
[![Build Status](https://travis-ci.org/Lisennk/Slack-Events.svg?branch=1.0.0)](https://travis-ci.org/Lisennk/Slack-Events)

*Work with Slack Events API as simple, as with native Laravel events and event listeners.*

**:link: Reasons to use this package to work with [Slack Events API](https://api.slack.com/events-api):**
* Based on native Laravel Events;
* Support all Slack Event types;
* Support token validation;
* Support url verification and "challenge" requests;
* PSR compitable code;
* Full documentation;
* Almost full test coverage;
* A lot of emoji in this documentation (even with cat! :cat2:).

## :earth_americas: Installation
**1)** Require Composer package
```bash
composer require lisennk/laravel-slack-events-api
```
**2)** Publish config 
```bash
php artisan vendor:publish
```
**3)** Open `config/app.php`, scroll down to `providers[]` array and add `\Lisennk\LaravelSlackEvents\SlackEventsServiceProvider::class` to it.

*For example:*
```php
// ...

'providers' => [
// ...
// A whole bunch of providers
// ...

\Lisennk\LaravelSlackEvents\SlackEventsServiceProvider::class
],

// ...
```
**3)** Open "[My Apps](https://api.slack.com/apps)" page and go to your app control panel. You will need to configure a few things here in the next 2 steps.

**4)** Go to "App Credentials" page, scroll down and copy "Verification Token".

<img src="https://cloud.githubusercontent.com/assets/8103985/17901937/ebdbdb3e-696d-11e6-96b4-b0794d74ed9a.png" alt="verification_token" style="height: 250px; width: auto;">

Open `config/slackEvents.php` and past this token as value for `'token'` key in the settings array:
```php
'token' => 'past-your-token-here'
```

**5)** Now open "Event Subscriptions" page. Here you must enable events, add events you wish to listen and set **Request URL**. Request URL is `'route'` key in your `config/slackEvents.php` file:
```php
return [
    /*
    |-------------------------------------------------------------
    | Your validation token from "App Credentials"
    |-------------------------------------------------------------
    */
    'token' => 'your-validation-token-here',

    /*
    |-------------------------------------------------------------
    | Events Request URL — path, where events will be served
    |-------------------------------------------------------------
    */
    'route' => '/api/slack/event/fire', // <===== THIS IS YOUR REQUEST URL
];
```
`'route'` works just like built-in Laravel routes, so if your site URL is `https://example.com` and your `'route'` is `/api/slack/event/fire`, than yhour full Request URL is `https://example.com/api/slack/event/fire`. You can leave it as it is or set your own route instead of default `/api/slack/event/fire`.

This pacakge do all verification and challenge work for you, so you only need to set your Request URL — by default its:
```
https://[your-site-url]/api/slack/event/fire
```
![request_url](https://cloud.githubusercontent.com/assets/8103985/17905448/b8ed582a-697b-11e6-890d-e0c1bcff0bd7.png)

## :fork_and_knife: Usage

**Also see [Quick Example](#example)**.

Thanks to this package, work with [Slack Events]((https://api.slack.com/events-api) is actually work with [Laravel Events](https://laravel.com/docs/master/events). So if you didn't read [Laravel Events documentation](https://laravel.com/docs/master/events) or [Slack Events API documentation]((https://api.slack.com/events-api) yet, its **highly recommended** to read it before start.

This package prodvides seperate Laravel Event class for [every event](https://api.slack.com/events), that have Slack Events API support. For example, `reaction_added` event implementation is `Lisennk\LaravelSlackEvents\Events\ReactionAdded` class.

Each Event class have public fields representing real Slack Event request:

| Field                 | Description                                                               |
|-----------------------|---------------------------------------------------------------------------|
| public $token;        | Verification token                                                        |
| public $team_id;      | The unique identifier for the team where this event occurred.             |
| public $api_app_id    | The unique identifier for the application this event is intended for.     |
| public $event;        | Contains the inner set of fields representing the event that's happening. |
| public $type;         | This reflects the type of callback you're receiving.                      |
| public $authed_users; | An array of string-based User IDs.                                        |

It's mean, if you want to get reaction name from [reaction_added](https://api.slack.com/events/reaction_added) event, you can get it from `ReactionAdded` event class like this:
```php
$reactionAdded->event->reaction; // reaction name, something like :thumbsup:
```

**Full list of supported events and their classes you will find below.**

So, now suppose, we want to make a `reaction_added` Slack Event listener. What we need to do?

### Example

**1)** Open `App/Listeners` directory or, if it doesn't exist, create it yourself. Now create new file, call it, for example, `ReactionAddedListener.php` and paste to it this code:
```php
<?php

namespace App\Listeners;

use \Lisennk\LaravelSlackEvents\Events\ReactionAdded;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReactionAddedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // Here you can setup something
    }

    /**
     * Handle the event.
     *
     * @param  ReactionAdded  $event
     * @return void
     */
    public function handle(ReactionAdded $reactionAdded)
    {
        // Do some magic with event data
        Log::info('New reaction added, reaction name is: ' . $reactionAdded->event->reaction);
    }
}

```
As you can see, it's normal event listener. You might notice that listener `implements ShouldQueue` — it's usefull, beacause due to Slack Events API terms, our app must respond to request **within three seconds**, so if you want some long-playing stuff in your event listener, you need to configure [queue](https://laravel.com/docs/5.2/queues).

**2)** Now we should add this listener to `/App/Providers/EventServiceProvider.php` file like any other event listener:
```php
// ...

protected $listen = [
        
        // ...

        \Lisennk\LaravelSlackEvents\Events\ReactionAdded::class => [
            \App\Listeners\ReactionAddedListener::class
        ]
    ];
    
// ...
```

**3)** Profit! You are ready to go. 

## :cherries: Full list of supported events and their classes

| [Event Name](https://api.slack.com/events) | [Event Class](https://github.com/Lisennk/Slack-Events/tree/master/src/Events)                    |
|------------|:-------------------------------------------------:|
|channel_archive|\Lisennk\LaravelSlackEvents\Events\ChannelArchive|
|channel_created|\Lisennk\LaravelSlackEvents\Events\ChannelCreated|
|channel_deleted|\Lisennk\LaravelSlackEvents\Events\ChannelDeleted|
|channel_history_changed|\Lisennk\LaravelSlackEvents\Events\ChannelHistoryChanged|
|channel_joined|\Lisennk\LaravelSlackEvents\Events\ChannelJoined|
|channel_rename|\Lisennk\LaravelSlackEvents\Events\ChannelRename|
|channel_unarchive|\Lisennk\LaravelSlackEvents\Events\ChannelUnarchive|
|dnd_updated|\Lisennk\LaravelSlackEvents\Events\DndUpdated|
|dnd_updated_user|\Lisennk\LaravelSlackEvents\Events\DndUpdatedUser|
|email_domain_changed|\Lisennk\LaravelSlackEvents\Events\EmailDomainChanged|
|emoji_changed|\Lisennk\LaravelSlackEvents\Events\EmojiChanged|
|file_change|\Lisennk\LaravelSlackEvents\Events\FileChange|
|file_comment_added|\Lisennk\LaravelSlackEvents\Events\FileCommentAdded|
|file_comment_deleted|\Lisennk\LaravelSlackEvents\Events\FileCommentDeleted|
|file_comment_edited|\Lisennk\LaravelSlackEvents\Events\FileCommentEdited|
|file_created|\Lisennk\LaravelSlackEvents\Events\FileCreated|
|file_deleted|\Lisennk\LaravelSlackEvents\Events\FileDeleted|
|file_public|\Lisennk\LaravelSlackEvents\Events\FilePublic|
|file_shared|\Lisennk\LaravelSlackEvents\Events\FileShared|
|file_unshared|\Lisennk\LaravelSlackEvents\Events\FileUnshared|
|group_archive|\Lisennk\LaravelSlackEvents\Events\GroupArchive|
|group_close|\Lisennk\LaravelSlackEvents\Events\GroupClose|
|group_history_changed|\Lisennk\LaravelSlackEvents\Events\GroupHistoryChanged|
|group_open|\Lisennk\LaravelSlackEvents\Events\GroupOpen|
|group_rename|\Lisennk\LaravelSlackEvents\Events\GroupRename|
|group_unarchive|\Lisennk\LaravelSlackEvents\Events\GroupUnarchive|
|im_close|\Lisennk\LaravelSlackEvents\Events\ImClose|
|im_created|\Lisennk\LaravelSlackEvents\Events\ImCreated|
|im_history_changed|\Lisennk\LaravelSlackEvents\Events\ImHistoryChanged|
|im_open|\Lisennk\LaravelSlackEvents\Events\ImOpen|
|message.channels|\Lisennk\LaravelSlackEvents\Events\MessageChannels|
|message.groups|\Lisennk\LaravelSlackEvents\Events\MessageGroups|
|message.im|\Lisennk\LaravelSlackEvents\Events\MessageIm|
|message.mpim|\Lisennk\LaravelSlackEvents\Events\MessageMpim|
|pin_added|\Lisennk\LaravelSlackEvents\Events\PinAdded|
|pin_removed|\Lisennk\LaravelSlackEvents\Events\PinRemoved|
|reaction_added|\Lisennk\LaravelSlackEvents\Events\ReactionAdded|
|reaction_removed|\Lisennk\LaravelSlackEvents\Events\ReactionRemoved|
|star_added|\Lisennk\LaravelSlackEvents\Events\StarAdded|
|star_removed|\Lisennk\LaravelSlackEvents\Events\StarRemoved|
|subteam_created|\Lisennk\LaravelSlackEvents\Events\SubteamCreated|
|subteam_self_added|\Lisennk\LaravelSlackEvents\Events\SubteamSelfAdded|
|subteam_self_removed|\Lisennk\LaravelSlackEvents\Events\SubteamSelfRemoved|
|subteam_updated|\Lisennk\LaravelSlackEvents\Events\SubteamUpdated|
|team_domain_change|\Lisennk\LaravelSlackEvents\Events\TeamDomainChange|
|team_join|\Lisennk\LaravelSlackEvents\Events\TeamJoin|
|team_rename|\Lisennk\LaravelSlackEvents\Events\TeamRename|
|url_verification|\Lisennk\LaravelSlackEvents\Events\UrlVerification|
|user_change|\Lisennk\LaravelSlackEvents\Events\UserChange|

## :hibiscus: Contributing

Feel free to star this repository, create pull requests, issues and report typos.

## :books: Reference 
* Read [Slack Events API official documentation](https://api.slack.com/events-api);
* Read [Laravel Events documentation](https://laravel.com/docs/master/events);
* For making Slack Web API calls we recommend to use [Laravel Slack API package](https://github.com/Lisennk/Laravel-Slack-Web-API).
