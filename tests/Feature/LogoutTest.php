<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Yungts97\LaravelUserActivityLog\Models\Log;


class LogoutTest extends TestCase
{
    /** @test */
    function it_can_log_on_logout()
    {
        $user = User::first();
        Auth::login($user);
        $this->assertDatabaseHas('logs', ['log_type' => 'login', 'user_id' => $user->id]);
        Auth::logout();
        $this->assertDatabaseHas('logs', ['log_type' => 'logout', 'user_id' => $user->id]);
    }

    /** @test */
    function it_can_invoke_logout_event()
    {
        Event::fake();
        $user = User::first();
        Auth::login($user);
        Event::assertDispatched(Login::class);
        Auth::logout();
        Event::assertDispatched(Logout::class);
    }

    /** @test */
    // function it_can_log_on_logout()
    // {
        
    // }
}