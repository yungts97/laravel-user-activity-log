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
    {
        $config_file = 'user-activity-log.php';
        $migration_file = '2022_01_17_000000_create_log_table.php';

        //config
        if (File::exists(config_path($config_file))) {
            if ($this->confirm("user-activity-log.php config file already exist. Do you want to overwrite it?")) {
                $this->info("Overwriting config file...");
                $this->publishConfig();
                $this->info("user-activity-log.php overwrite finished.");
            } else {
                $this->info("Skipped config file publish.");
            }
        } else {
            $this->publishConfig();
            $this->info("Config file published");
        }

        //migration
        if (File::exists(database_path("migrations/$migration_file"))) {
            if ($this->confirm("2022_01_17_000000_create_log_table.php migration file already exist. Do you want to overwrite it?")) {
                $this->info("Overwriting migration file...");
                $this->publishMigration();
                $this->info("2022_01_17_000000_create_log_table.php overwrite finished.");
            } else {
                $this->info("Skipped migration file publish.");
            }
        } else {
            $this->publishMigration();
            $this->info("Migration file published.");
        }

        $this->line('=====================================================');
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