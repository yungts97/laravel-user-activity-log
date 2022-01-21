<?php

namespace Yungts97\LaravelUserActivityLog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Log extends Model
{
    // disable laravel auto insert created_at & updated_at fields
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'log_datetime',
        'table_name',
        'log_type',
        'request_info',
        'data',
    ];

    // eager load 
    protected $with = ['user'];

    // append addition fields
    protected $appends = ['current_data', 'humanize_datetime'];

    // attribute casting
    protected $casts = [
        'log_datetime' => 'datetime',
        'request_info' => 'array',
        'data' => 'array',
    ];

    // eloquent relationship
    public function user()
    {
        $userInstance = config('user-activity-log.user_model', '\App\Models\User');
        return $this->belongsTo($userInstance);
    }

    // global scope
    protected static function booted()
    {
        static::addGlobalScope('new_to_old', function (Builder $builder) {
            $builder->orderBy('log_datetime', 'desc');
        });
    }

    // local scope
    public function scopeViewThisMonthActivity($query)
    {
        return $query
            ->whereMonth('log_datetime', date('m'))
            ->whereYear('log_datetime', date('Y'));
    }

    // additiona attribute for model
    public function getHumanizeDatetimeAttribute()
    {
        return $this->log_datetime->diffForHumans();
    }

    // additiona attribute for model
    public function getCurrentDataAttribute()
    {
        if (is_null($this->data) || $this->log_type === 'create') return null;
        return DB::table($this->table_name)->find($this->data['id']);
    }
}
