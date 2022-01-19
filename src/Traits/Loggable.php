<?php

namespace Yungts97\LaravelUserActivityLog\Traits;

use Yungts97\LaravelUserActivityLog\Models\Log;

trait Loggable
{
    static function logging($model, $log_type)
    {
        if (!auth()->check() || $model->excludeLogging) return;

        // get the request info
        $request_info = [
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent()
        ];

        // get the model original data
        $original_data = $log_type === 'create' ? 
            $model : 
            $model->getRawOriginal();

        // insert log record
        Log::create([
            'user_id' => auth()->user()->id,
            'log_datetime' => date('Y-m-d H:i:s'),
            'table_name' => $model->getTable(),
            'log_type' => $log_type,
            'request_info' => (object)$request_info,
            'data' => (object)$original_data
        ]);
    }

    public static function bootLoggable()
    {
        if (config('user-activity-log.events.edit', false)) {
            self::updated(function ($model) {
                self::logging($model, 'edit');
            });
        }

        if (config('user-activity-log.events.delete', false)) {
            self::deleted(function ($model) {
                self::logging($model, 'delete');
            });
        }

        if (config('user-activity-log.events.create', false)) {
            self::created(function ($model) {
                self::logging($model, 'create');
            });
        }
    }
}
