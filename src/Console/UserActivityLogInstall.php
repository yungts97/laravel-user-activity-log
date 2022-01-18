<?php

namespace Yungts97\LaravelUserActivityLog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class UserActivityLogInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-activity-log:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preparing all the files it needed for the user activity log package.';

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
    {   $config_file = 'user-activity-log.php';
        $migration_file = '2022_01_17_000000_create_log_table.php';

        if(File::exists(config_path($config_file)))
        {
            if ($this->confirm("user-activity.php config file already exist. Do you want to overwrite?")) {
                $this->publishConfig();
                $this->info("config overwrite finished");
            } else {
                $this->info("skipped config publish");
            }
        }
        else
        {
            $this->publishConfig();
            $this->info("config published");
        }

        //migration
        if (File::exists(database_path("migrations/$migration_file"))) {
            if ($this->confirm("migration file already exist. Do you want to overwrite?")) {
                $this->publishMigration();
                $this->info("migration overwrite finished");
            } else {
                $this->info("skipped migration publish");
            }
        } else {
            $this->publishMigration();
            $this->info("migration published");
        }

        $this->line('-----------------------------');
        if (!Schema::hasTable('logs')) {
            $this->call('migrate');
        }
    }

    private function publishConfig()
    {
        $this->call('vendor:publish', [
            '--provider' => "Yungts97\LaravelUserActivityLog\UserActivityLogServiceProvider",
            '--tag'      => 'config',
            '--force'    => true
        ]);
    }

    private function publishMigration()
    {
        $this->call('vendor:publish', [
            '--provider' => "Yungts97\LaravelUserActivityLog\UserActivityLogServiceProvider",
            '--tag'      => 'migrations',
            '--force'    => true
        ]);
    }
}
