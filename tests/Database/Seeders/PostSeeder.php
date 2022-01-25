<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use Yungts97\LaravelUserActivityLog\Tests\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::withoutEvents(function () {
            Post::factory(5)->create();
        });
    }
}
