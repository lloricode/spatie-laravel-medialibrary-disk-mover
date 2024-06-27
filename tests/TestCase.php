<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\SpatieLaravelMediaLibraryDiskMoverServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Lloricode\\SpatieLaravelMediaLibraryDiskMover\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SpatieLaravelMediaLibraryDiskMoverServiceProvider::class,
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
