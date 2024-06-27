<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\Commands\MoveMediaToDiskCommand;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

it('move disk', function () {

    $model = createModel();

    assertDatabaseEmpty(Media::class);

    $media = addMediaToModel($model);

    assertDatabaseCount(Media::class, 1);
    assertDatabaseHas(Media::class, [
        'disk' => 'public',
        'conversions_disk' => 'public',
    ]);

    Storage::disk('s3')
        ->assertMissing(
            mediaPath($media, 's3')
        );

    artisan(MoveMediaToDiskCommand::class, [
        'fromDisk' => 'public',
        'toDisk' => 's3',
    ])
        ->assertSuccessful();

    $media->refresh();

    assertDatabaseCount(Media::class, 1);
    assertDatabaseHas(Media::class, [
        'disk' => 's3',
        'conversions_disk' => 's3',
    ]);

    Storage::disk('s3')
        ->assertExists(
            mediaPath($media, 's3')
        );

});
