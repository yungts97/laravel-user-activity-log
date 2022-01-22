<?php

namespace Yungts97\LaravelUserActivityLog\Listeners;

class LoginListener extends Listener
{
    public function __construct()
    {
        parent::__construct("login");
    }
}