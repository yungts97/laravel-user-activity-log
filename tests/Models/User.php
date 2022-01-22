<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Models;

use Illuminate\Contracts\Auth\Authenticatable;

class User extends BaseModel implements Authenticatable
{
    protected $table = 'users';

    protected $guarded = [];

    protected $fillable = ['id', 'name'];

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