<?php

namespace Yungts97\LaravelUserActivityLog\Tests;

use Yungts97\LaravelUserActivityLog\UserActivityLogServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
    // additional setup
  }

  protected function getPackageProviders($app)
  {
    return [
        UserActivityLogServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {
    // perform environment setup
  }
}