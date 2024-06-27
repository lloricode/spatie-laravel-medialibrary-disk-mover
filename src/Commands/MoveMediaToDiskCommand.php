<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Commands;

use Illuminate\Console\Command;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\Jobs\CollectMediaToMoveJob;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'media-library:move-disk', description: 'Move media from disk to a new disk')]
class MoveMediaToDiskCommand extends Command
{
    protected $signature = 'media-library:move-disk {fromDisk} {toDisk}';

    /**
     * @throws \Throwable
     */
    public function handle(): int
    {
        $diskNameFrom = (string) $this->argument('fromDisk');
        $diskNameTo = (string) $this->argument('toDisk');

        $this->checkIfDiskExists($diskNameFrom);
        $this->checkIfDiskExists($diskNameTo);

        dispatch(new CollectMediaToMoveJob($diskNameFrom, $diskNameTo));

        $this->components->info('Done!');

        return self::SUCCESS;
    }

    /**
     * @throws \Throwable
     */
    private function checkIfDiskExists(string $diskName): void
    {
        if (! config("filesystems.disks.{$diskName}.driver")) {
            $this->fail("Disk driver for disk `{$diskName}` not set.");
        }
    }
}
