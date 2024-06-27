<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CollectMediaToMoveJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly string $diskNameFrom,
        private readonly string $diskNameTo,
        private readonly ?int $offset = null
    ) {}

    public function handle(): void
    {
        $recordsToMove = Media::where('disk', $this->diskNameFrom);

        if ($this->offset) {
            $recordsToMove->where('id', '>', $this->offset);
        }

        $recordsToMove = $recordsToMove->limit($limit = 1000)
            ->get();

        $recordsToMove->each(
            fn (Media $media) => dispatch(
                new MoveMediaToDiskJob($media, $this->diskNameFrom, $this->diskNameTo)
            )
        );

        if ($recordsToMove->count() === $limit) {
            dispatch(new CollectMediaToMoveJob($this->diskNameFrom, $this->diskNameTo, $recordsToMove->last()->id));
        }

    }
}
