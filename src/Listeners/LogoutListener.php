<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

class LogoutListener extends Listener
{
    public function __construct()
    {
        parent::__construct('logout');
    }
}