<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

class CreatedListener extends ModelListener
{
    public function __construct()
    {
        parent::__construct("create");
    }
}
