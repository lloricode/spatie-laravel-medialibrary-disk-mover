<?php

declare(strict_types=1);

namespace Lloricode\SpatieLaravelMediaLibraryDiskMover\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TestModel extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'test_model';

    protected $guarded = [];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300);
        $this->addMediaConversion('size-sm')
            ->width(600);
        $this->addMediaConversion('size-md')
            ->width(800);
        $this->addMediaConversion('size-lg')
            ->width(1000);
        $this->addMediaConversion('size-xl')
            ->width(1400);
        $this->addMediaConversion('size-xl2')
            ->width(2000);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }
}
