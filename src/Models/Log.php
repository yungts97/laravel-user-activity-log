<?php

namespace Yungts97\LaravelUserActivityLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Log extends Model
{
    public $timestamps = false;
    public $dates = ['log_datetime'];
    protected $fillable = [
        'user_id',
        'log_datetime',
        'table_name',
        'log_type',
        'request_info',
        'data',
    ];
    protected $with = ['user'];
    protected $appends = ['current_data', 'humanize_datetime'];
    protected $casts = [
        'request_info' => 'array',
        'data' => 'array',
    ];

    public function user()
    {
        $userInstance = config('user-activity-log.model.user') ?? '\App\Models\User';
        return $this->belongsTo($userInstance);
    }

    public function getHumanizeDatetimeAttribute()
    {
        return $this->log_datetime->diffForHumans();
    }

    public function scopeViewThisMonthActivity($query)
    {
        return $query->whereMonth('log_datetime', date('m'))->whereYear('log_datetime', date('Y'))->orderBy('log_datetime', 'desc');
    }

    public function getCurrentDataAttribute()
    {
        if(is_null($this->data) || $this->log_type === 'create') return null;
        return DB::table($this->table_name)->find($this->data['id']);
    }
}
