<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Illuminate\Auth\Events\Login;
use Yungts97\LaravelUserActivityLog\Listeners\LoginListener;

class LoginEventTest extends TestCase
{
    /** @test */
    function invoke_login_event_listener()
    {
        
    }
}