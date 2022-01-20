<?php
return [
    # add your own middleware here
    'middleware' => ['api', 'auth'],

    # user model
    'model' => [
        'user' => "App\Models\User"
    ],

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

    # timezone for log date time
    'timezone' => 'UTC'
];