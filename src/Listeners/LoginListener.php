<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Yungts97\LaravelUserActivityLog\Models\Log;

class LoginListener
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Login $event)
    {
        if (!config('user-activity-log.log_events.on_login', false)) return;

        $user = $event->user;
        $log_datetime = date('Y-m-d H:i:s');

        $request_info = [
            'ip'         => $this->request->ip(),
            'user_agent' => $this->request->userAgent()
        ];

        Log::create([
            'user_id'       => $user->id,
            'log_datetime'  => $log_datetime,
            'log_type'      => 'login',
            'request_info'  => json_encode($request_info)
        ]);
    }
}
