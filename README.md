<h1 align="center">Laravel User Activity Log</h1>
<p align="center">
    <a href="https://packagist.org/packages/yungts97/laravel-user-activity-log">
        <img src="https://badgen.net/packagist/v/yungts97/laravel-user-activity-log"/>
    </a>
    <a href="https://opensource.org/licenses/mit-license.php">
        <img src="https://badges.frapsoft.com/os/mit/mit.png?v=103"/>
    </a>
    <a href="https://packagist.org/packages/yungts97/laravel-user-activity-log">
        <img src="https://badgen.net/packagist/dt/yungts97/laravel-user-activity-log"/>
    </a>
</p>

`yungts97/laravel-user-activity-log` is a package for Laravel 8.x that provides easy to use features to log the activities of the users of your Laravel app. It provides automatic logging for the model events without complicated action. All activity will be stored in the `logs` table. 


## Installation
You can install the package via composer:
```bash
composer require yungts97/laravel-user-activity-log
```

The package will automatically register a service provider.

After that, we still need one more step to complete the installation by run this command. 
```bash
php artisan user-activity-log:install
```

## How to use?
This package is very simple and easy to use. The only thing you need to do is use the `Loggable` trait in your model class.
```php
use Illuminate\Database\Eloquent\Model;
use Yungts97\LaravelUserActivityLog\Traits\Loggable;

class Post extends Model
{
    use Loggable; // add it in here
    ...
}
```

You can retrieve all activity using the `Yungts97\LaravelUserActivityLog\Models\Log` model.
```php
Log::all();
```

## Configuration
You can change the configuration of this package on `config/user-activity-log.php`.
```php
return [
    # add your own middleware here
    'middleware' => ['api', 'auth'],

    # user model
    'user_model' =>  "App\Models\User",

    # exclude tables for filter option
    'exclude_tables' => [
        'logs',
        'migrations',
        'failed_jobs',
        'password_resets',
        'personal_access_tokens',
    ],

    # events to log
    'events' => [
        'create' => true,
        'edit'   => true,
        'delete' => true,
        'login'  => true,
        'logout' => true
    ],

    # timezone for log date time
    'timezone' => 'UTC'
];
```

## Routes
| Endpoint              | Method  | Response Format | Description                                     |
| --------------------- | ------- | --------------- | ----------------------------------------------- | 
| `/logs`               | `GET`   | JSON            | To retrieve user activity logs.                 |
| `logs/filter-options` | `GET`   | JSON            | To retrieve filter options for filtering logs.  |
| `logs/{log_id}`       | `GET   `| JSON            | To retrieve specific activity log.              |

Available paramaters for log filtering:
| Parameter             | Type      | Description                                     |
| --------------------- | --------- | ----------------------------------------------- | 
| `page`                | `integer` | The page number for log pagination.             |
| `itemsPerPage`        | `integer` | The number item per page for log pagination     |
| `userId`              | `integer` | Filtering logs by the user ID.                  |
| `logType`             | `string`  | Filtering logs by log type.                     |
| `tableName`           | `string`  | Filtering logs by the table name.               |
| `dateFrom`            | `string`  | Filtering logs by the date range.               |
| `dateTo`              | `string`  | Filtering logs by the date range.               |

Example: `http://example.com/logs?page=1&itemsPerPage=10&userId=517`