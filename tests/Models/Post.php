<?php
namespace Yungts97\LaravelUserActivityLog\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yungts97\LaravelUserActivityLog\Tests\Database\Factories\PostFactory;

class Post extends BaseModel
{
    use HasFactory;

    protected $table = 'posts';

    protected $guarded = [];

    protected $fillable = ['id', 'name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return PostFactory::new();
    }
}