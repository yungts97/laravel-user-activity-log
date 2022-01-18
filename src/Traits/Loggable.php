<?php

namespace Yungts97\LaravelUserActivityLog\Traits;

use Yungts97\LaravelUserActivityLog\Models\Log;

trait Loggable
{
    static function logging($model, $log_type)
    {
        if (!auth()->check() || $model->excludeLogging) return;
        if ($log_type == 'create') $original_data = json_encode($model);
        else {
            if (version_compare(app()->version(), '7.0.0', '>='))
                $original_data = json_encode($model->getRawOriginal()); // getRawOriginal available from Laravel 7.x
            else
                $original_data = json_encode($model->getOriginal());
        }

        $request_info = [
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent()
        ];

        Log::create([
            'user_id' => auth()->user()->id,
            'log_datetime' => date('Y-m-d H:i:s'),
            'table_name' => $model->getTable(),
            'log_type' => $log_type,
            'request_info' => json_encode($request_info),
            'data' => json_encode($original_data)
        ]);
    }

    public static function bootLoggable()
    {
        if (config('user-activity-log.log_events.on_edit', false)) {
            self::updated(function ($model) {
                self::logging($model, 'edit');
            });
        }


        if (config('user-activity-log.log_events.on_delete', false)) {
            self::deleted(function ($model) {
                self::logging($model, 'delete');
            });
        }


        if (config('user-activity-log.log_events.on_create', false)) {
            self::created(function ($model) {
                self::logging($model, 'create');
            });
        }
    }
}
