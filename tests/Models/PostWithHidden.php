<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Models;

class PostWithHidden extends BaseModel
{
    protected $table = 'posts';

    protected $guarded = [];

    protected $fillable = ['id', 'name'];

    public $log_hidden = ['name']; // to hide the "name" attribute on logging

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}