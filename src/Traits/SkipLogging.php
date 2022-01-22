<?php

namespace Yungts97\LaravelUserActivityLog\Traits;

trait SkipLogging
{
    public function initializeSkipLogging()
    {
        $this->dispatchesEvents = [];
    }
}