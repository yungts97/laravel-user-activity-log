<?php

namespace Yungts97\LaravelUserActivityLog\Traits;

use Yungts97\LaravelUserActivityLog\Models\Log;
use Yungts97\LaravelUserActivityLog\Events\CreatedModel;
use Yungts97\LaravelUserActivityLog\Events\DeletedModel;
use Yungts97\LaravelUserActivityLog\Events\UpdatedModel;

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

    public function logs()
    {
        return Log::where([
            ['table_name', $this->getTable()],
            ['data->id', $this->id]
        ])->get();
    }
}