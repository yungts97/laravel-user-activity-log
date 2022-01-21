<?php

namespace Yungts97\LaravelUserActivityLog\Controllers;

use Yungts97\LaravelUserActivityLog\Models\Log;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonTimeZone;

class UserActivityLogController extends Controller
{
    public function index()
    {
        $itemsPerPage = request()->input('itemsPerPage') ?? 10;
        $userId = request()->input('userId');
        $logType = request()->input('logType');
        $tableName = request()->input('tableName');
        $dateFrom = request()->input('dateFrom');
        $dateTo = request()->input('dateTo');

        $logs = $this->isApplyingFilter($userId, $logType, $tableName, $dateFrom, $dateTo) ?
            $this->applyFilter($userId, $logType, $tableName, $dateFrom, $dateTo, $itemsPerPage) :
            Log::viewThisMonthActivity()->paginate($itemsPerPage);

        return response()->json($logs);
    }

    public function show(Log $log)
    {
        return response()->json($log);
    }

    public function getFilterOption()
    {
        // prepare sql for select table name from database
        $connection = config('database.default');
        $driver = DB::connection($connection)->getDriverName();
        $sql = match($driver){
            'pgsql' => "SELECT table_name FROM information_schema.tables where table_schema = '%s' ORDER BY table_schema,table_name;",
            'sqlite' => "SELECT name as table_name FROM sqlite_master WHERE type='table' ORDER BY name",
            'mysql' => "SHOW TABLES",
        };
        
        // prepare tables
        $table_names = array_map('current', DB::select($sql));
        $exclude_tables = config('user-activity-log.exclude_tables', []);
        $table_names = array_diff($table_names, $exclude_tables);

        // prepare log types
        $log_types = config('user-activity-log.events', []);
        $log_types = array_filter($log_types);
        $log_types = array_keys($log_types);

        return response()->json([
            'table_names' => [...$table_names],
            'log_types' => $log_types
        ]);
    }

    private function isApplyingFilter(...$args)
    {
        // filter out all the null values
        $args = array_filter($args);
        return count($args) > 0;
    }

    private function applyFilter($userId, $logType, $tableName, $dateFrom, $dateTo, $itemsPerPage)
    {
        $logs = new Log(); 
        if ($userId) $logs = $logs->where('user_id', $userId);
        if ($logType) $logs = $logs->where('log_type', $logType);
        if ($tableName) $logs = $logs->where('table_name', $tableName);
        if ($dateFrom && $dateTo) {
            $offsetTimezone = CarbonTimeZone::create(config('user-activity-log.timezone', 'UTC'))->toOffsetTimeZone(); // +08:00
            $dateFrom = "$dateFrom 00:00:00";
            $dateTo = "$dateTo 23:59:59";
            $logs = $logs->whereRaw("CONVERT_TZ(log_datetime, '+00:00', '$offsetTimezone') BETWEEN '$dateFrom' AND '$dateTo'");
        }
        return $logs->paginate($itemsPerPage);
    }
}
