<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover;

use Lloricode\SpatieLaravelMediaLibraryDiskMover\Commands\MoveMediaToDiskCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SpatieLaravelMediaLibraryDiskMoverServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('spatie-laravel-medialibrary-disk-mover')
            ->hasCommand(MoveMediaToDiskCommand::class);
    }
}
