# :bell: Slack Events API for Laravel :bell:
[![Latest Stable Version](https://poser.pugx.org/lisennk/laravel-slack-web-api/v/stable)](https://packagist.org/packages/lisennk/laravel-slack-web-api)
[![Total Downloads](https://poser.pugx.org/lisennk/laravel-slack-web-api/downloads)](https://packagist.org/packages/lisennk/laravel-slack-web-api)
[![License](https://poser.pugx.org/lisennk/laravel-slack-web-api/license)](https://packagist.org/packages/lisennk/laravel-slack-web-api)
[![Build Status](https://travis-ci.org/Lisennk/Laravel-Slack-Web-API.svg?branch=master)](https://travis-ci.org/Lisennk/Laravel-Slack-Web-API)

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

