<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

class DeletedListener extends ModelListener
{
    public function __construct()
    {
        parent::__construct("delete");
    }
}
