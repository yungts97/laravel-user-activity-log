<?php
return [
    'middleware'       => ['api', 'auth'],
    'delete_limit'     => 7, // default 7 days

    
    'model' => [
        'user' => "App\Models\User"
    ],

    # exclude tables for fi
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