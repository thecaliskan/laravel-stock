<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;
use TheCaliskan\Stock\Data\ForexData;
use TheCaliskan\Stock\Exceptions\InvalidDateException;
use TheCaliskan\Stock\Facades\Stock;

it('success single', function ($date) {
    $forex = Stock::forex('C:USDTRY', $date);

    expect($forex)
        ->toBeObject()
        ->toBeInstanceOf(ForexData::class)
        ->toMatchObject([
            'symbol' => 'C:USDTRY',
        ])
        ->and($forex->timestamp)
        ->toBeInstanceOf(Carbon::class)
        ->and($forex->lowestPrice)
        ->toBeLessThanOrEqual($forex->highestPrice)
        ->toBeLessThanOrEqual($forex->openPrice)
        ->toBeLessThanOrEqual($forex->closePrice)
        ->and($forex->highestPrice)
        ->toBeGreaterThanOrEqual($forex->lowestPrice)
        ->toBeGreaterThanOrEqual($forex->openPrice)
        ->toBeGreaterThanOrEqual($forex->closePrice)
        ->and($forex->numberOfTransactions)
        ->toBeGreaterThanOrEqual(1);
})->with([now()->addWeeks(-1)->startOfWeek(), now()->addWeeks(-1)->startOfWeek()->format('Y-m-d'), null]);

it('success collections', function () {
    expect(Stock::forex())
        ->toBeObject()
        ->toBeInstanceOf(Collection::class)
        ->toContainOnlyInstancesOf(ForexData::class)
        ->count()
        ->toBeGreaterThanOrEqual(1000);
});

it('failed lower date', function () {
    Stock::forex('C:USDTRY', now()->addYear(-4)->startOfWeek());
})->throws(InvalidDateException::class);

it('failed highest date', function () {
    Stock::forex('C:USDTRY', now());
})->throws(InvalidDateException::class);

it('failed date format', function () {
    Stock::forex('C:USDTRY', now()->format('Y-m-da'));
})->throws(InvalidDateException::class);
