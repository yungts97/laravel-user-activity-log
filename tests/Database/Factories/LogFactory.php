<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Database\Factories;

use Yungts97\LaravelUserActivityLog\Tests\Models\Log;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Log::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $table_names = ['users', 'posts'];
        $log_types = ['login', 'logout', 'create', 'edit', 'delete'];

        $request_info = [
            'ip' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
        $data = [
            'id' => $this->faker->unique(),
            'name' => $this->faker->name(),
        ];
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        
        return [
            'user_id' => $user->id,
            'log_datetime' => $this->faker->dateTime(),
            'table_name' => $table_names[array_rand($table_names, 1)],
            'log_type' => $log_types[array_rand($log_types, 1)],
            'request_info' => (object)$request_info,
            'data' => (object)$data,
        ];
    }
}
