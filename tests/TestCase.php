<?php

namespace ParcelTrap\Laravel\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ParcelTrap\Laravel\Facades\ParcelTrap;
use ParcelTrap\Laravel\ParcelTrapServiceProvider;

class TestCase extends OrchestraTestCase
{
    /** {@inheritdoc} */
    protected function getPackageProviders($app): array
    {
        return [
            ParcelTrapServiceProvider::class,
        ];
    }

    /** {@inheritdoc} */
    protected function getPackageAliases($app): array
    {
        return [
            'ParcelTrap' => ParcelTrap::class,
        ];
    }
}
