<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\SpatieLaravelMediaLibraryDiskMoverServiceProvider;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\Tests\Fixtures\TestModel;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        foreach (array_keys(config('filesystems.disks')) as $disk) {
            Storage::fake($disk);
        }

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Lloricode\\SpatieLaravelMediaLibraryDiskMover\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            SpatieLaravelMediaLibraryDiskMoverServiceProvider::class,
            MediaLibraryServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        config()->set('queue.default', 'sync');

        $migration = include __DIR__.'/../vendor/spatie/laravel-medialibrary/database/migrations/create_media_table.php.stub';
        $migration->up();

        Schema::create((new TestModel)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
}
