<?php
return [
    'activated'        => true, // active/inactive all logging
    'middleware'       => ['web', 'auth'],
    'delete_limit'     => 7, // default 7 days

    'model' => [
        'user' => "App\Models\User"
    ],

    'log_events' => [
        'on_create'     => true,
        'on_edit'       => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_logout'    => true
    ]
];