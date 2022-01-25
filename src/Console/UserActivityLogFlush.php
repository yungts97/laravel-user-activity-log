<?php

namespace Yungts97\LaravelUserActivityLog\Console;

use Illuminate\Console\Command;
use Yungts97\LaravelUserActivityLog\Models\Log;

class UserActivityLogFlush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-activity-log:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all the user activity log records that in the database.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm('Do you wish to continue?', false)) {
            Log::truncate();
        }
    }
    
}
