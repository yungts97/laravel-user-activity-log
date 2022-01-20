<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;
use Yungts97\LaravelUserActivityLog\Tests\Models\Post;
use Illuminate\Support\Facades\Auth;

class UserActivityLogTest extends TestCase
{
    /** @test */
    function it_can_log_on_create_event()
    {
        //user login
        $user = User::first();
        Auth::login($user);

        //create a post
        $newPost = new Post(['name' => 'Post 1']);
        $user->posts()->save($newPost);

        //checking database have the activity log record
        $this->assertDatabaseHas('logs', [
            'log_type' => 'create',
            'user_id' => $user->id,
            'table_name' => 'posts'
        ]);
    }

    /** @test */
    function it_can_log_on_edit_event()
    {
        //user login
        $user = User::first();
        Auth::login($user);

        //create a post
        $newPost = new Post(['name' => 'Post 1']);
        $user->posts()->save($newPost);

        //edit the post
        $newPost->name = "Post 1 edited";
        $newPost->save();

        //checking database have the activity log record
        $this->assertDatabaseHas('logs', [
            'log_type' => 'edit',
            'user_id' => $user->id,
            'table_name' => 'posts'
        ]);
    }

    /** @test */
    function it_can_log_on_delete_event()
    {
        //user login
        $user = User::first();
        Auth::login($user);

        //create a post
        $newPost = new Post(['name' => 'Post 1']);
        $user->posts()->save($newPost);

        //delete the post
        $newPost->delete();

        //checking database have the activity log record
        $this->assertDatabaseHas('logs', [
            'log_type' => 'delete',
            'user_id' => $user->id,
            'table_name' => 'posts'
        ]);
    }
}
