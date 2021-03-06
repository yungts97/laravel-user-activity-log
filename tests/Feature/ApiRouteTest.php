<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Yungts97\LaravelUserActivityLog\Tests\Models\Post;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;

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

    /** @test */
    function it_can_retrieve_logs_with_filter()
    {
        $user = User::first();
        Auth::login($user);

        // Act
        $response = $this->getJson('/api/logs?userId=1&logType=login');

        // Assert
        $response->assertStatus(200);
    }

    /** @test */
    function it_can_retrieve_logs_with_filter_by_id()
    {
        $user = User::first();
        Auth::login($user);

        //create a post
        $newPost = new Post(['name' => 'Post 1']);
        $user->posts()->save($newPost);

        // Act
        $response = $this->getJson("/api/logs?tableName=posts&dataId={$newPost->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data', 1)->etc()
        );
    }

    /** @test */
    function it_can_retrieve_a_log()
    {
        $user = User::first();
        Auth::login($user);

        // Act
        $response = $this->getJson('/api/logs/1');

        // Assert
        $response->assertStatus(200);
    }

    /** @test */
    function it_can_retrieve_filter_options()
    {
        $user = User::first();
        Auth::login($user);

        // Act
        $response = $this->getJson('/api/logs/filter-options');

        // Assert
        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) => $json->hasAll('table_names', 'log_types')
        );
    }

    /** @test */
    function it_can_delete_log()
    {
        $user = User::first();
        Auth::login($user);

        // Act
        $response = $this->deleteJson('/api/logs');

        // Assert
        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) => $json->hasAll('message')
        );
    }
}