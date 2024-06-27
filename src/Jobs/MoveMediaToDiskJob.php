<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

class MoveMediaToDiskJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Media $media,
        private readonly string $diskNameFrom,
        private readonly string $diskNameTo,
        private readonly ?string $queueName = null,
    ) {
        $this->queue = $this->queueName ?? config('media-library.queue_name');
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        if ($this->media->disk !== $this->diskNameFrom) {
            throw new \Exception("Current media disk `{$this->media->disk}` is not the expected `{$this->diskNameFrom}` disk.");
        }

        $mediaPath = PathGeneratorFactory::create($this->media)
            ->getPath($this->media);

        $diskFrom = Storage::disk($this->diskNameFrom);
        $filesInDirectory = $diskFrom->allFiles($mediaPath);
        $jobs = collect();

        foreach ($filesInDirectory as $fileInDirectory) {
            $jobs->push(new MoveMediaFileToDiskJob($this->diskNameFrom, $this->diskNameTo, $fileInDirectory));
        }

        if ($jobs->count() === 0) {
            throw new \Exception('No jobs found to dispatch.');
        }

        $jobs->push(new MoveMediaUpdateDiskJob($this->media, $this->diskNameTo));

        Bus::chain($jobs)->dispatch();
    }
}
