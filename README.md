<h1 align="center">Laravel User Activity Log</h1>
<p align="center">
    <a href="https://packagist.org/packages/yungts97/laravel-user-activity-log">
        <img src="https://img.shields.io/packagist/v/yungts97/laravel-user-activity-log?color=24BDCC"/>
    </a>
    <a href="https://github.com/yungts97/laravel-user-activity-log/blob/v1.0.0/LICENSE.md">
        <img src="https://img.shields.io/packagist/l/yungts97/laravel-user-activity-log"/>
    </a>
    <a href="https://packagist.org/packages/yungts97/laravel-user-activity-log">
        <img src="https://img.shields.io/packagist/dt/yungts97/laravel-user-activity-log?color=ff69b4"/>
    </a>
</p>

`yungts97/laravel-user-activity-log` is a package for Laravel 8.x that provides easy to use features to log the activities of the users of your Laravel app. It provides automatic logging for the model events without complicated action. All activity will be stored in the `logs` table. 

## Environment Requirements
`PHP`: ^8.0

`Laravel`: ^8.x

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
This package is very simple and easy to use. The only thing you need to do is add the `Loggable` trait in your model class.
```php
use Illuminate\Database\Eloquent\Model;
use Yungts97\LaravelUserActivityLog\Traits\Loggable;

class Post extends Model
{
    use Loggable; // add it in here
    ...
}
```

It might troublesome if you have a lot of models. You could have a base class for your models and add `Loggable` trait in your base model.
```php
# BaseModel.php
use Illuminate\Database\Eloquent\Model;
use Yungts97\LaravelUserActivityLog\Traits\Loggable;

class BaseModel extends Model
{
    use Loggable;
}

# PostModel.php
class Post extends BaseModel
{
    ...
}
```

If you don't want to log for any child class of the base model, you can add `SkipLogging` trait to skip the log for the model.
```php
use Yungts97\LaravelUserActivityLog\Traits\SkipLogging;

class Post extends BaseModel
{
    use SkipLogging;
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
    # add your own middleware here (route middleware)
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
| `/logs/filter-options` | `GET`   | JSON            | To retrieve filter options for filtering logs.  |
| `/logs/{log_id}`       | `GET   `| JSON            | To retrieve specific activity log.              |

Available paramaters for log filtering:
| Parameter             | Type      | Description                                     |
| --------------------- | --------- | ----------------------------------------------- | 
| `page`                | `integer` | The page number for log pagination.             |
| `itemsPerPage`        | `integer` | The number item per page for log pagination     |
| `userId`              | `integer` | Filtering logs by the user ID.                  |
| `logType`             | `string`  | Filtering logs by log type.                     |
| `tableName`           | `string`  | Filtering logs by the table name.               |
| `dateFrom`            | `string`  | Filtering logs by the date range. **(Must have dateFrom & dateTo paramaters)**              |
| `dateTo`              | `string`  | Filtering logs by the date range. **(Must have dateFrom & dateTo paramaters)**              |

Exp. `http://example.com/logs?page=1&itemsPerPage=10&userId=517`

### Sample Response
`/logs`
```json
{
    "current_page": 1,
    "data": [
        {
            "id": 77,
            "user_id": 942,
            "log_datetime": "2022-01-22T05:56:57.000000Z",
            "table_name": null,
            "log_type": "login",
            "request_info": {
                "ip": "192.121.0.56",
                "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36"
            },
            "data": null,
            "current_data": null,
            "humanize_datetime": "17 seconds ago",
            "user": {
                "id": 1,
                "name": "User 1",
            }
        },
    ],
    "first_page_url": "http://localhost/api/logs?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://localhost/api/logs?page=1",
    "links": [
        {
            "url": null,
            "label": "&laquo; Previous",
            "active": false
        },
        {
            "url": "http://localhost/api/logs?page=1",
            "label": "1",
            "active": true
        },
    ],
    "next_page_url": null,
    "path": "http://localhost/api/logs",
    "per_page": "10",
    "prev_page_url": null,
    "to": 10,
    "total": 1
}

```
`/logs/filter-options`
```json
{
    "table_names": [
        "posts",
        "users",
    ],
    "log_types": [
        "create",
        "edit",
        "delete",
        "login",
        "logout"
    ]
}
```
`/logs/77`
```json
{
            "id": 77,
            "user_id": 942,
            "log_datetime": "2022-01-22T05:56:57.000000Z",
            "table_name": null,
            "log_type": "login",
            "request_info": {
                "ip": "192.121.0.56",
                "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36"
            },
            "data": null,
            "current_data": null,
            "humanize_datetime": "17 seconds ago",
            "user": {
                "id": 1,
                "name": "User 1",
            }
        },
```
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.