<?php
namespace Yungts97\LaravelUserActivityLog\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use Yungts97\LaravelUserActivityLog\Tests\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::withoutEvents(function() {
            Admin::factory(5)->create();
        });
    }
}