<?php

namespace Yungts97\LaravelUserActivityLog;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Yungts97\LaravelUserActivityLog\Events\CreatedModel;
use Yungts97\LaravelUserActivityLog\Events\UpdatedModel;
use Yungts97\LaravelUserActivityLog\Events\DeletedModel;
use Yungts97\LaravelUserActivityLog\Listeners\LogoutListener;
use Yungts97\LaravelUserActivityLog\Listeners\LoginListener;
use Yungts97\LaravelUserActivityLog\Listeners\CreatedListener;
use Yungts97\LaravelUserActivityLog\Listeners\UpdatedListener;
use Yungts97\LaravelUserActivityLog\Listeners\DeletedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;


class UserActivityLogEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        Login::class   => [
            LoginListener::class
        ],
        Logout::class => [
            LogoutListener::class
        ],
        CreatedModel::class => [
            CreatedListener::class
        ],
        UpdatedModel::class => [
            UpdatedListener::class
        ],
        DeletedModel::class => [
            DeletedListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}