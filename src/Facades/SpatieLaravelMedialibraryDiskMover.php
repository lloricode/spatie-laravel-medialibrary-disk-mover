<?php

namespace Lloricode\SpatieLaravelMedialibraryDiskMover\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lloricode\SpatieLaravelMedialibraryDiskMover\SpatieLaravelMedialibraryDiskMover
 */
class SpatieLaravelMedialibraryDiskMover extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Lloricode\SpatieLaravelMedialibraryDiskMover\SpatieLaravelMedialibraryDiskMover::class;
    }
}
