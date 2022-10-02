<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

use Yungts97\LaravelUserActivityLog\Traits\ListenerTraits\HasData;
use Yungts97\LaravelUserActivityLog\Traits\ListenerTraits\HasTableName;

class ModelListener extends Listener
{
    use HasTableName, HasData;

    public function __construct(string $event_name = "")
    {
        parent::__construct($event_name);
    }
}
