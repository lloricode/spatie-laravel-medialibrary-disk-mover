<?php

namespace Lloricode\SpatieLaravelMedialibraryDiskMover\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Lloricode\SpatieLaravelMedialibraryDiskMover\SpatieLaravelMedialibraryDiskMoverServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Lloricode\\SpatieLaravelMedialibraryDiskMover\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SpatieLaravelMedialibraryDiskMoverServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_spatie-laravel-medialibrary-disk-mover_table.php.stub';
        $migration->up();
        */
    }
}
