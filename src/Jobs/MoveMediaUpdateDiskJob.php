<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MoveMediaUpdateDiskJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Media $media,
        private readonly string $diskNameTo,
        private readonly ?string $queueName = null,
    ) {
        $this->queue = $this->queueName ?? config('media-library.queue_name');
    }

    public function handle(): void
    {
        $this->media->disk = $this->diskNameTo;
        $this->media->conversions_disk = $this->diskNameTo;

        $this->media->save();
    }
}
