<?php
return [
    # add your own middleware here (route middleware)
    'middleware' => ['api', 'auth'],

    # user model class
    'user_model' =>  "App\Models\User",

    # exclude tables for filter option
    'exclude_tables' => [
        'logs',
        'migrations',
        'failed_jobs',
        'password_resets',
        'personal_access_tokens',
    ],

    # events to log
    'events' => [
        'create' => true,
        'edit'   => true,
        'delete' => true,
        'login'  => true,
        'logout' => true
    ],

    # timezone for log date time (Change to your region time zone)
    # UTC is always the time zone being recorded.
    # define your timezone to have the accurate logs time and filtered record (Especially filtered by date time)
    'timezone' => 'UTC'
];