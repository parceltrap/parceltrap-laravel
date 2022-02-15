<?php

declare(strict_types=1);

namespace ParcelTrap\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use ParcelTrap\ParcelTrap as ParcelTrapCore;

/** @mixin ParcelTrapCore */
class ParcelTrap extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ParcelTrapCore::class;
    }
}
