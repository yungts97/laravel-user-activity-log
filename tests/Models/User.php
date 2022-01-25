<?php
namespace Yungts97\LaravelUserActivityLog\Tests\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yungts97\LaravelUserActivityLog\Tests\Database\Factories\UserFactory;

class User extends BaseModel implements Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $guarded = [];

    protected $fillable = ['id', 'name'];

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        $name = $this->getAuthIdentifierName();

        return $this->attributes[$name];
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'];
    }

    public function getRememberToken()
    {
        return 'token';
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return 'tokenName';
    }
}