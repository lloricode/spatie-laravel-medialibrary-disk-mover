<?php

namespace Lloricode\SpatieLaravelMedialibraryDiskMover\Commands;

use Illuminate\Console\Command;

class SpatieLaravelMedialibraryDiskMoverCommand extends Command
{
    public $signature = 'spatie-laravel-medialibrary-disk-mover';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
