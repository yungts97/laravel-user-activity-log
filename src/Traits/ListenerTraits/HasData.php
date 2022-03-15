<?php

namespace Yungts97\LaravelUserActivityLog\Traits\ListenerTraits;

trait HasData
{
    protected function getData()
    {
        return $this->event_name === 'create' ?
            $this->event->model->makeHidden($this->event->model->log_hidden ?? []) :
            $this->event->model->makeHidden($this->event->model->log_hidden ?? [])->getRawOriginal();
    }
}