<?php

namespace Yungts97\LaravelUserActivityLog\Traits;

use Yungts97\LaravelUserActivityLog\Events\CreatedModel;
use Yungts97\LaravelUserActivityLog\Events\UpdatedModel;
use Yungts97\LaravelUserActivityLog\Events\DeletedModel;

trait Loggable
{
    public function initializeLoggable()
    {
        $this->dispatchesEvents = [
            'created' => CreatedModel::class,
            'updated' => UpdatedModel::class,
            'deleted' => DeletedModel::class,
        ];
    }
}