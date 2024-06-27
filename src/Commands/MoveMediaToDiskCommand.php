<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Commands;

use Illuminate\Console\Command;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\Jobs\CollectMediaToMoveJob;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'move-media-to-disk', description: 'Move media from disk to a new disk')]
class MoveMediaToDiskCommand extends Command
{
    protected $signature = 'move-media-to-disk {fromDisk} {toDisk}';

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
