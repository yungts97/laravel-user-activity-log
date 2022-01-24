<?php

namespace Yungts97\LaravelUserActivityLog\Tests\Feature;

use Yungts97\LaravelUserActivityLog\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class CommandTest extends TestCase
{
    /** @test */
    function it_can_delete_logs_via_command()
    {
        // // make sure we're starting from a clean state
        // if (File::exists(config_path('blogpackage.php'))) {
        //     unlink(config_path('blogpackage.php'));
        // }

        // $this->assertFalse(File::exists(config_path('blogpackage.php')));

        Artisan::call('user-activity-log:clean --month=6');

        $this->assertTrue(File::exists(config_path('blogpackage.php')));
    }
}