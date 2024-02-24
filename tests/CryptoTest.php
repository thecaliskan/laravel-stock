<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;
use TheCaliskan\Stock\Data\CryptoData;
use TheCaliskan\Stock\Exceptions\InvalidDateException;
use TheCaliskan\Stock\Facades\Stock;

it('success single', function ($date) {
    $crypto = Stock::crypto('X:BTCUSD', $date);

    expect($crypto)
        ->toBeObject()
        ->toBeInstanceOf(CryptoData::class)
        ->toMatchObject([
            'symbol' => 'X:BTCUSD',
        ])
        ->and($crypto->timestamp)
        ->toBeInstanceOf(Carbon::class)
        ->toBeCarbon(is_null($date) ? now()->addDays(-1)->format('Y-m-d') : ($date instanceof Carbon ? $date->format('Y-m-d') : Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d')), 'Y-m-d')
        ->and($crypto->lowestPrice)
        ->toBeLessThanOrEqual($crypto->highestPrice)
        ->toBeLessThanOrEqual($crypto->openPrice)
        ->toBeLessThanOrEqual($crypto->closePrice)
        ->and($crypto->highestPrice)
        ->toBeGreaterThanOrEqual($crypto->lowestPrice)
        ->toBeGreaterThanOrEqual($crypto->openPrice)
        ->toBeGreaterThanOrEqual($crypto->closePrice)
        ->and($crypto->numberOfTransactions)
        ->toBeGreaterThanOrEqual(1);
})->with([now()->addWeeks(-1)->startOfWeek(), now()->addWeeks(-1)->startOfWeek()->format('Y-m-d'), null]);

it('success collections', function () {
    expect(Stock::crypto())
        ->toBeObject()
        ->toBeInstanceOf(Collection::class)
        ->toContainOnlyInstancesOf(CryptoData::class)
        ->count()
        ->toBeGreaterThanOrEqual(200);
});

it('failed lower date', function () {
    Stock::crypto('X:BTCUSD', now()->addYear(-4)->startOfWeek());
})->throws(InvalidDateException::class);

it('failed highest date', function () {
    Stock::crypto('X:BTCUSD', now());
})->throws(InvalidDateException::class);

it('failed date format', function () {
    Stock::crypto('X:BTCUSD', now()->format('Y-m-da'));
})->throws(InvalidDateException::class);
