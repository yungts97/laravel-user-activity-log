<?php

namespace Yungts97\LaravelUserActivityLog\Traits\ListenerTraits;

use Illuminate\Support\Arr;

trait HasData
{
    protected function getData()
    {
        if ($this->event_name === 'create')
            return Arr::except($this->event->model->toArray(), $this->event->model->log_hidden ?? []);

        $mode = config("user-activity-log.mode", 'simple');
        return $this->event_name === 'edit' && $mode === 'simple' ?
            Arr::except([...$this->event->model->getChanges(), 'id' => $this->event->model->id], $this->event->model->log_hidden ?? []) :
            Arr::except($this->event->model->getRawOriginal(), $this->event->model->log_hidden ?? []);
    }
}
