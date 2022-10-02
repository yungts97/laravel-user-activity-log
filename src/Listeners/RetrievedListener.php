<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

class RetrievedListener extends ModelListener
{
    public function __construct()
    {
        parent::__construct("retrieve");
    }
}
