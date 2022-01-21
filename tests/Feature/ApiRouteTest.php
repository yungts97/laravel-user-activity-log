<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Yungts97\LaravelUserActivityLog\Models\Log;


class ApiRouteTest extends TestCase
{
    /** @test */
    function it_can_retrieve_logs()
    {
        $user = User::first();
        Auth::login($user);

        // Act
        $response = $this->getJson('/api/logs');
        
        // Assert
        $response->assertStatus(200);
    }
}