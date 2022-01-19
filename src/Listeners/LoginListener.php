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
        if (!config('user-activity-log.events.login', false)) return;

        // get the request info
        $request_info = [
            'ip'         => $this->request->ip(),
            'user_agent' => $this->request->userAgent()
        ];

        // insert log record
        Log::create([
            'user_id'       => $event->user->id,
            'log_datetime'  => date('Y-m-d H:i:s'),
            'log_type'      => 'login',
            'request_info'  => (object)$request_info
        ]);
    }
}
