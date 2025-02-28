<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class MoveMediaFileToDiskJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly string $diskNameFrom,
        private readonly string $diskNameTo,
        private readonly string $filename,
        private readonly ?string $queueName = null,
    ) {
        $this->queue = $this->queueName ?? Config::string('media-library.queue_name');
    }

    public function handle(): void
    {
        $diskFrom = Storage::disk($this->diskNameFrom);
        $diskTo = Storage::disk($this->diskNameTo);

        $diskTo->put(
            $this->filename,
            $diskFrom->readStream($this->filename)
        );
    }
}
