<?php

namespace Yungts97\LaravelUserActivityLog;

use Illuminate\Support\ServiceProvider;
use Yungts97\LaravelUserActivityLog\Console\UserActivityLogInstall;

class UserActivityLogServiceProvider extends ServiceProvider
{
    // constant variables
    const CONFIG_PATH = __DIR__ . '/../config/user-activity-log.php';
    const ROUTE_PATH = __DIR__ . '/../routes';
    const MIGRATION_PATH = __DIR__ . '/../database/migrations';

    public function boot()
    {
        // publishing
        $this->publishes([self::CONFIG_PATH => config_path('user-activity-log.php')], 'config');
        $this->publishes([self::MIGRATION_PATH => database_path('migrations')], 'migrations');

        // load routes
        $this->loadRoutesFrom(self::ROUTE_PATH . '/api.php');
    }

    public function register()
    {
        //merging config
        $this->mergeConfigFrom(self::CONFIG_PATH, 'user-activity-log');

        // register event service provider
        $this->app->register(UserActivityLogEventServiceProvider::class);

        // register artisan commands
        $this->commands([UserActivityLogInstall::class]);
    }
}