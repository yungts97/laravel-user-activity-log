<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

class UpdatedListener extends ModelListener
{
    public function __construct()
    {
        parent::__construct("edit");
    }
}
