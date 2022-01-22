<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Yungts97\LaravelUserActivityLog\Traits\Loggable;

class BaseModel extends Model
{
    use Loggable;
}