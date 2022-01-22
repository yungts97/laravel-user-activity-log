<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Models;

use Yungts97\LaravelUserActivityLog\Traits\SkipLogging;

class PostWithoutLog extends BaseModel
{
    use SkipLogging;

    protected $table = 'posts';

    protected $guarded = [];

    protected $fillable = ['id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}