<?php

namespace Yungts97\LaravelUserActivityLog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class UpdatedModel
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Model $model)
    {
    }
}