<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Yungts97\LaravelUserActivityLog\Traits\Loggable;

class Post extends Model
{
    use Loggable; 
    
    protected $table = 'posts';

    protected $guarded = [];

    protected $fillable = ['id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
