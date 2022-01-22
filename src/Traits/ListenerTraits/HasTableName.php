<?php

namespace Yungts97\LaravelUserActivityLog\Traits\ListenerTraits;

trait HasTableName
{
    protected function getTableName()
    {
        return $this->event->model->getTable();
    }
}