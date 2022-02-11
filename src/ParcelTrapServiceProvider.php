<?php

declare(strict_types=1);

namespace ParcelTrap\Laravel;

use InvalidArgumentException;
use ParcelTrap\ParcelTrap;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ParcelTrapServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('parceltrap')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(ParcelTrap::class, function ($app) {
            $config = $app['config']['parceltrap'] ?? [];

            return tap(ParcelTrap::make(), static function (ParcelTrap $client) use ($config) {
                // @phpstan-ignore-next-line
                collect($config['drivers'] ?? [])->each(
                    function (array $driverConfig = null, string $driverName) use ($client) {
                        if (! isset($driverConfig['driver']) || ! class_exists($driverConfig['driver'])) {
                            throw new InvalidArgumentException('A driver class must be specified in the configuration');
                        }

                        $client->addDriver(
                            name: $driverName,
                            driver: $driverConfig['driver']::make($driverConfig),
                        );
                    }
                );
            });
        });
    }
}
