<?php

namespace Yungts97\LaravelUserActivityLog;

use Yungts97\LaravelUserActivityLog\Listeners\LogoutListener;
use Yungts97\LaravelUserActivityLog\Listeners\LoginListener;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;


class UserActivityLogEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        Login::class   => [
            LoginListener::class
        ],
        Logout::class => [
            LogoutListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}