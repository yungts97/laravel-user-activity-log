<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

use Yungts97\LaravelUserActivityLog\Traits\ListenerTraits\HasTableName;
use Yungts97\LaravelUserActivityLog\Traits\ListenerTraits\HasData;

class CreatedListener extends Listener
{
    use HasTableName, HasData;

    public function __construct()
    {
        parent::__construct("create");
    }
}