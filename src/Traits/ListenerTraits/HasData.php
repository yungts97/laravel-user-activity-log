<?php

namespace Yungts97\LaravelUserActivityLog\Traits\ListenerTraits;

trait HasData
{
    protected function getData()
    {
        return $this->event_name === 'create' ?
            $this->event->model :
            $this->event->model->getRawOriginal();
    }
}