<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Models;

class Post extends BaseModel
{
    protected $table = 'posts';

    protected $guarded = [];

    protected $fillable = ['id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}