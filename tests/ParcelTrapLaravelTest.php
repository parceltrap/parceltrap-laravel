<?php

declare(strict_types=1);

use ParcelTrap\DTOs\TrackingDetails;
use ParcelTrap\Laravel\Tests\NullDriver;
use ParcelTrap\Laravel\Tests\TestCase;
use ParcelTrap\ParcelTrap;

uses(TestCase::class);

beforeEach(fn () => config()->set('parceltrap', [
    'default' => 'null',

    'drivers' => [
        'null' => [
            'driver' => NullDriver::class,
        ],
    ],
]));

it('can retrieve the ParcelTrap manager from the container', function () {
    expect(app(ParcelTrap::class))->toBeInstanceOf(ParcelTrap::class);
});

it('can retrieve a ParcelTrap driver from the container', function () {
    expect(app(ParcelTrap::class))
        ->driver()->toBeInstanceOf(NullDriver::class)
        ->driver('null')->toBeInstanceOf(NullDriver::class);

    expect(app(ParcelTrap::class)->driver('null')->find('ABCDEFG'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('ABCDEFG')
        ->estimatedDelivery->toEqual(new DateTimeImmutable('2022-01-01'));
});

it('can call methods via the ParcelTrap facade', function () {
    expect(\ParcelTrap\Laravel\Facades\ParcelTrap::find('ABCDEFG'))
        ->toBeInstanceOf(TrackingDetails::class)
        ->identifier->toBe('ABCDEFG')
        ->estimatedDelivery->toEqual(new DateTimeImmutable('2022-01-01'));
});

it('throws an exception when the default driver is not set', function () {
    config()->set('parceltrap.default');

    app(ParcelTrap::class);
})->throws(InvalidArgumentException::class);

it('throws an exception when a driver config is provided without a driver key', function () {
    config()->set('parceltrap.drivers.null.driver');

    app(ParcelTrap::class);
})->throws(InvalidArgumentException::class);
