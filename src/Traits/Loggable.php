<?php

namespace Yungts97\LaravelUserActivityLog\Traits;

use Yungts97\LaravelUserActivityLog\Models\Log;
use Yungts97\LaravelUserActivityLog\Events\CreatedModel;
use Yungts97\LaravelUserActivityLog\Events\DeletedModel;
use Yungts97\LaravelUserActivityLog\Events\UpdatedModel;
use Yungts97\LaravelUserActivityLog\Events\RetrievedModel;

trait Loggable
{
    public function initializeLoggable()
    {
        $this->dispatchesEvents = [
            'created' => CreatedModel::class,
            'updated' => UpdatedModel::class,
            'deleted' => DeletedModel::class,
            'retrieved' => RetrievedModel::class,
        ];
    }

    public function log()
    {
        return $this->hasOne(Log::class, 'data->id', 'id')->where('table_name', $this->getTable());
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'data->id', 'id')->where('table_name', $this->getTable());
    }
}
