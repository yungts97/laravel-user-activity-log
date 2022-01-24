<?php

namespace Yungts97\LaravelUserActivityLog\Console;

use Illuminate\Console\Command;
use Yungts97\LaravelUserActivityLog\Models\Log;

class UserActivityLogCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-activity-log:clean 
                            {flush?   : all}
                            {--day=   : To delete user activity log that older than this days }
                            {--month= : Number of days that old}
                            {--year=  : A year of the user activity log to delete}
                            {--date=  : A specific date of user activity log to delete}
                            {--force  : Whether the user activity log should be permanently delete.}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the user activity log records that in the database.';

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
        $scopeOptions = [
            'day' => $this->option('day'),
            'month' => $this->option('month'),
            'year' => $this->option('year'),
            'date' => $this->option('date'),
        ];
        $flagOptions = [
            'force' => $this->option('force'),
        ];

        $valuedScopeOptions = array_filter($scopeOptions);
        if (count($valuedScopeOptions) > 1)
            return $this->error('Too many options! You only able to have 1 scope option [day, month, year, date] with 1 flag scope [force]');

        if (!$this->validateOptions($valuedScopeOptions))
            return $this->error('Too many options! You only able to have 1 scope option [day, month, year, date] with 1 flag scope [force]');

        dd(date('m'));
    }

    protected function validateOptions(array $option)
    {
        $key = array_keys($option)[0];
        $log = new Log();
        if ($key === 'day') return is_numeric($option[$key]);
        else if ($key === 'month') return is_numeric($option[$key]) && (+$option[$key] >= 1 && +$option[$key] <= 12);
        else if ($key === 'year') return is_numeric($option[$key]) && (+$option[$key] >= 1950 && +$option[$key] <= 9999);
        else return (bool)strtotime($option[$key]);

        if ($key === 'day') $log->whereRaw('log_date < NOW() - INTERVAL ? DAY', $option[$key]);
        else if ($key === 'month') $log->whereMonth('log_datetime', $option[$key]);
        else if ($key === 'year') $log->whereYear('log_datetime', $option[$key]);
        else if ($key === 'date') $log->whereDate('log_datetime', $option[$key]);
        else $log->whereRaw('log_date < NOW() - INTERVAL ? DAY', 30);
    }
}
