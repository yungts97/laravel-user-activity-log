<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Yungts97\LaravelUserActivityLog\Tests\Database\Seeders\LogSeeder;
use Yungts97\LaravelUserActivityLog\Tests\Models\Log;

class CommandTest extends TestCase
{
    /** @test */
    function it_can_delete_logs_via_command_with_day_option()
    {
        $before8Days = Date('Y-m-d H:i:s', strtotime('-8 days'));
        
        Log::factory(3)->state(['log_datetime' => $before8Days])->create();
        Log::factory(2)->state(['log_datetime' => Date('Y-m-d H:i:s')])->create();
        $this->assertCount(5, Log::all());

        $this->artisan('user-activity-log:clean --day=7');
        $this->assertCount(2, Log::all());
    }

    /** @test */
    function it_can_delete_logs_via_command_with_month_option()
    {
        Log::factory(5)->state(['log_datetime' => '2022-01-25 03:30:36'])->create();
        $this->assertCount(5, Log::all());

        $this->artisan('user-activity-log:clean --month=1/2022');
        $this->assertCount(0, Log::all());
    }

    /** @test */
    function it_can_delete_logs_via_command_with_year_option()
    {
        Log::factory(5)->state(['log_datetime' => '2022-01-25 03:30:36'])->create();
        Log::factory(1)->state(['log_datetime' => '2021-01-25 03:30:36'])->create();
        $this->assertCount(6, Log::all());

        $this->artisan('user-activity-log:clean --year=2022');
        $this->assertCount(1, Log::all());
    }

    /** @test */
    function it_can_delete_logs_via_command_with_date_option()
    {
        Log::factory(1)->state(['log_datetime' => '2022-01-25 03:30:36'])->create();
        Log::factory(1)->state(['log_datetime' => '2022-01-28 03:30:36'])->create();
        Log::factory(1)->state(['log_datetime' => '2022-01-29 03:30:36'])->create();
        Log::factory(1)->state(['log_datetime' => '2022-01-29 03:35:36'])->create();
        Log::factory(1)->state(['log_datetime' => '2022-01-29 03:38:36'])->create();
        $this->assertCount(5, Log::all());

        $this->artisan('user-activity-log:clean --date=29/01/2022');
        $this->assertCount(2, Log::all());
    }

    /** @test */
    function it_can_delete_logs_via_command_without_option()
    {
        $before31Days = Date('Y-m-d H:i:s', strtotime('-31 days'));
        
        Log::factory(3)->state(['log_datetime' => $before31Days])->create();
        Log::factory(2)->state(['log_datetime' => Date('Y-m-d H:i:s')])->create();
        $this->assertCount(5, Log::all());

        $this->artisan('user-activity-log:clean');
        $this->assertCount(2, Log::all());
    }

    /** @test */
    function it_can_trigger_error_message()
    {
        $this->artisan('user-activity-log:clean --year=2021 --month=12/2021')
            ->expectsOutput('Too many options! You only able to have 1 scope option [day, month, year, date] with 1 flag scope [force]');

        $this->artisan('user-activity-log:clean --year=999')
            ->expectsOutput('Invalid option value! [year]. Year must be 1950 - 2200');
            
        $this->artisan('user-activity-log:clean --month=10-2022')
            ->expectsOutput('Invalid option value! [month]. Month must in mm/yyyy format');

        $this->artisan('user-activity-log:clean --date=29/13/2022')
            ->expectsOutput('Invalid option value! [date]. Date must in dd/mm/yyyy format');

        $this->artisan('user-activity-log:clean --day=ab')
            ->expectsOutput('Invalid option value! [day]. Day be numeric value');
    }

    /** @test */
    function it_can_flush_log_via_command()
    {
        $this->seed([LogSeeder::class]);
        $this->assertCount(5, Log::all());
        
        $this->artisan('user-activity-log:flush')->expectsConfirmation('Do you wish to continue?', 'yes');
        $this->assertCount(0, Log::all());
    }
}
