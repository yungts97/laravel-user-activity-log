<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;

class LoginTest extends TestCase
{
    /** @test */
    function it_can_log_on_login()
    {
        $user = User::first();
        Auth::login($user);
        $this->assertDatabaseHas('logs', ['log_type' => 'login', 'user_id' => $user->id]);
    }

    /** @test */
    function it_can_invoke_login_event()
    {
        Event::fake();
        $user = User::first();
        Auth::login($user);
        Event::assertDispatched(Login::class);
    }
}