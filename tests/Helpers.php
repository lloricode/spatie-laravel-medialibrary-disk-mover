<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\Tests\Fixtures\TestModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

function createModel(): TestModel
{
    $model = new TestModel;
    $model->name = fake()->word();
    $model->save();

    return $model;
}

function addMediaToModel(HasMedia $model): Media
{
    return $model->addMedia(UploadedFile::fake()->image('test.png'))
        ->toMediaCollection('images');
}

function mediaPath(Media $media, string $diskName): string
{
   return Str::replace(
        Storage::disk($diskName)->path(''),
        '',
        $media->getPath()
    );
}
