<?php
namespace Yungts97\LaravelUserActivityLog\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::withoutEvents(function() {
            User::factory(5)->create();
        });
    }
}