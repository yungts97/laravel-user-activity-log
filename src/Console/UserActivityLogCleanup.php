<?php

namespace Yungts97\LaravelUserActivityLog\Console;

use Illuminate\Support\Facades\DB;
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

        $valuedScopeOptions = filter_empty($scopeOptions); // should be only one option in the array, if not then return error.
        if (count($valuedScopeOptions) > 1)
            return $this->error('Too many options! You only able to have 1 scope option [day, month, year, date] with 1 flag scope [force]');

        if (!$this->validateOptions($valuedScopeOptions)) {
            $key = get_key($valuedScopeOptions);
            $message = match ($key) {
                'day' => 'Day be numeric value',
                'month' => 'Month must in mm/yyyy format',
                'year' => 'Year must be 1950 - 2200',
                'date' => 'Date must in dd/mm/yyyy format',
            };
            return $this->error("Invalid option value! [$key]. $message");
        }

        $this->deleteLog($valuedScopeOptions);
    }
    protected function validateOptions(array $option)
    {
        $key = get_key($option);
        if (!$key) return true;
        else if ($key === 'day') return is_numeric($option[$key]);
        else if ($key === 'month') return is_month_year($option[$key]);
        else if ($key === 'year') return is_year($option[$key]);
        else return is_date($option[$key]);
    }

    protected function deleteLog(array $scopeOption)
    {
        $key = get_key($scopeOption);
        $log = new Log();
        if ($key === 'month')
        {
            [$month, $year] = explode('/', $scopeOption[$key]);
            $log = $log->whereMonth('log_datetime', $month)->whereYear('log_datetime', $year);
        } 
        else if ($key === 'year') $log = $log->whereYear('log_datetime', $scopeOption[$key]);
        else if ($key === 'date') $log = $log->whereDate('log_datetime', toYmd($scopeOption[$key]));
        else 
        {
            [$sql, $value] = $this->prepareQueryForDay($scopeOption[$key] ?? 30);
            $log = $log->whereRaw($sql, $value);
        }
        $log->delete();
    }

    protected function prepareQueryForDay($value)
    {
        $connection = config('database.default');
        $driver = DB::connection($connection)->getDriverName();

        $sql = match ($driver) {
            'sqlite' => "log_datetime < DATETIME('now', ?)",
            'mysql' => "log_datetime < NOW() - INTERVAL ? DAY",
        };

        $value = match ($driver) {
            'sqlite' => "-$value days",
            'mysql' => $value,
        };
        return [$sql, $value];
    }
}
