<?php

declare(strict_types=1);

use Lloricode\SpatieLaravelMediaLibraryDiskMover\Commands\MoveMediaToDiskCommand;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;

it('move disk', function () {

    $model = createModel();

    assertDatabaseEmpty(Media::class);

    addMediaToModel($model);

    assertDatabaseCount(Media::class, 1);
    assertDatabaseHas(Media::class, [
        'disk' => 'public',
        'conversions_disk' => 'public',
    ]);

    artisan(MoveMediaToDiskCommand::class, [
        'fromDisk' => 'public',
        'toDisk' => 's3',
    ])
        ->assertSuccessful();

    assertDatabaseCount(Media::class, 1);
    assertDatabaseHas(Media::class, [
        'disk' => 's3',
        'conversions_disk' => 's3',
    ]);

});
