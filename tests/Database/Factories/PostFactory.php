<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Database\Factories;

use Yungts97\LaravelUserActivityLog\Tests\Models\Post;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::withoutEvents(function () {
                return User::factory(1)->create();
            })->id,
            'name' => $this->faker->name(),
        ];
    }
}