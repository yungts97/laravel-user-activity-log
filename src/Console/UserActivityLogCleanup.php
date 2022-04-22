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
                            {--day=   : Delete user activity log older than N days.}
                            {--month= : Delete user activity logs for a month of the year.}
                            {--year=  : Delete user activity logs for a year.}
                            {--date=  : Delete user activity logs for a specific date.}
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
        // get input values from command line
        $options = [
            'day' => $this->option('day'),
            'month' => $this->option('month'),
            'year' => $this->option('year'),
            'date' => $this->option('date'),
        ];
        
        $valuedOptions = filter_empty($options);
        if (count($valuedOptions) > 1)
            // should be only one option in the array, if not then return error.
            return $this->error('Too many options! You only able to have 1 option [day, month, year, date].');

        [$key, $value] = get_key_and_value($valuedOptions);
        if (!$this->isValidOption($key, $value)) {
            $errorMessage = match ($key) {
                'day' => 'Day be numeric value',
                'month' => 'Month must in mm/yyyy format',
                'year' => 'Year must be 1950 - 2200',
                'date' => 'Date must in dd/mm/yyyy format',
            };
            return $this->error("Invalid option value! [$key]. $errorMessage");
        }
        return $this->deleteLog($key, $value);
    }

    /**
     *  This function is used to validate the options.
     */
    protected function isValidOption(?string $key, ?string $value)
    {
        if (!$key) return true;
        else if ($key === 'day') return is_numeric($value);
        else if ($key === 'month') return is_month_year($value);
        else if ($key === 'year') return is_year($value);
        else return is_date($value);
    }

    /**
     *  This function is perform log deletion.
     */
    protected function deleteLog(?string $key, ?string $value)
    {
        $log = new Log();
        $log = match ($key) {
            'year' => $log->whereYear('log_datetime', $value),
            'date' => $log->whereDate('log_datetime', toYmd($value)),
            'month' => $log->whereMonthYear($value),
            default => $log->whereRaw($this->prepareQueryForDay($value ?? 7)), // day (default by 7 days old once no option applied)
        };
        $affected = $log->delete();
        $this->info("Deleted logs: $affected");
        return $affected;
    }

    /**
     *  This function is prepare raw query for day.
     */
    protected function prepareQueryForDay($value)
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        $sql = match ($driver) {
            'sqlite' => "log_datetime < DATETIME('now', '-$value days')",
            'mysql' => "log_datetime < NOW() - INTERVAL $value DAY",
        };
        return $sql;
    }
}