<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Lloricode\SpatieLaravelMediaLibraryDiskMover\Tests\Fixtures\TestModel;
use Spatie\MediaLibrary\HasMedia;

function createModel(): TestModel
{
    $model = new TestModel;
    $model->name = fake()->word();
    $model->save();

    return $model;
}

function addMediaToModel(HasMedia $model): void
{
    $model->addMedia(UploadedFile::fake()->image('test.png'))
        ->toMediaCollection('images');
}
