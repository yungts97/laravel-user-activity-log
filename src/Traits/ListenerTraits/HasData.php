<?php

namespace Yungts97\LaravelUserActivityLog\Traits\ListenerTraits;

use Illuminate\Support\Arr;

trait HasData
{
    protected function getData()
    {
        return $this->event_name === 'create' ?
            Arr::except($this->event->model->toArray(), $this->event->model->log_hidden ?? []) :
            Arr::except($this->event->model->getRawOriginal(), $this->event->model->log_hidden ?? []);
    }
}