<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Yungts97\LaravelUserActivityLog\Models\Log;

class LogoutListener
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle(Logout $event)
    {
        if (!config('user-activity-log.events.logout', false)) return;
        
        // get the request info
        $request_info = [
            'ip'         => $this->request->ip(),
            'user_agent' => $this->request->userAgent()
        ];

        // insert log record
        Log::create([
            'user_id'       => $event->user->id,
            'log_datetime'  => date('Y-m-d H:i:s'),
            'log_type'      => 'logout',
            'request_info'  => (object)$request_info
        ]);

    }
}