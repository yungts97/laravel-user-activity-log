<?php
namespace Yungts97\LaravelUserActivityLog\Tests\Database\Seeders;

use Illuminate\Database\Seeder;
use Yungts97\LaravelUserActivityLog\Tests\Models\Log;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Log::withoutEvents(function (){
            Log::factory(5)->create();
        });
    }
}