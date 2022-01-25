<?php
namespace Yungts97\LaravelUserActivityLog\Tests;

use Yungts97\LaravelUserActivityLog\UserActivityLogServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Encryption\Encrypter;
use Illuminate\Database\Schema\Blueprint;
use Yungts97\LaravelUserActivityLog\Tests\Models\User;
use Yungts97\LaravelUserActivityLog\Tests\Database\Seeders\UserSeeder;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            UserActivityLogServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('user-activity-log.user_model', 'Yungts97\LaravelUserActivityLog\Tests\Models\User');
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        config()->set('auth.providers.users.model', User::class);
        config()->set('app.key', 'base64:' . base64_encode(
            Encrypter::generateKey(config()['app.cipher'])
        ));
    }

    protected function setUpDatabase()
    {
        $this->migrateActivityLogTable();

        $this->createTables('users', 'posts');
        
        $this->seed([
            UserSeeder::class,
        ]);
    }

    protected function migrateActivityLogTable()
    {
        require_once __DIR__ . '/../database/migrations/2022_01_17_000000_create_log_table.php';
        if (!Schema::hasTable('logs')) {
            (new \CreateLogTable())->up();
        }
    }

    protected function createTables(...$tableNames)
    {
        collect($tableNames)->each(function (string $tableName) {
            Schema::create($tableName, function (Blueprint $table) use ($tableName) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->timestamps();
                $table->softDeletes();

                if ($tableName === 'posts') {
                    $table->integer('user_id')->unsigned()->nullable();
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                }
            });
        });
    }
}