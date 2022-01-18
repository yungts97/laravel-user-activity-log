<?php

namespace Yungts97\LaravelUserActivityLog\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'table_name',
        'log_type',
        'request_info',
        'data',
    ];

    public function user()
    {
        $userInstance = config('user-activity-log.model.user') ?? '\App\Models\User';
        return $this->belongsTo($userInstance);
    }

    public function scopeViewThisMonthActivity($query)
    {
        return $query->whereMonth('log_datetime', date('m'))->whereYear('log_datetime', date('Y'));
    }
}
