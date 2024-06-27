<?php

namespace Lloricode\SpatieLaravelMedialibraryDiskMover;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Lloricode\SpatieLaravelMedialibraryDiskMover\Commands\SpatieLaravelMedialibraryDiskMoverCommand;

class SpatieLaravelMedialibraryDiskMoverServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('spatie-laravel-medialibrary-disk-mover')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_spatie-laravel-medialibrary-disk-mover_table')
            ->hasCommand(SpatieLaravelMedialibraryDiskMoverCommand::class);
    }
}
