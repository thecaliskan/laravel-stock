<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\ItemNotFoundException;
use TheCaliskan\Stock\Data\StockData;
use TheCaliskan\Stock\Exceptions\InvalidDateException;
use TheCaliskan\Stock\Facades\Stock;

it('success single', function ($date) {
    $stock = Stock::stock('TEAM', $date);

    expect($stock)
        ->toBeObject()
        ->toBeInstanceOf(StockData::class)
        ->toMatchObject([
            'symbol' => 'TEAM',
        ])
        ->and($stock->timestamp)
        ->toBeInstanceOf(Carbon::class)
        ->and($stock->lowestPrice)
        ->toBeLessThanOrEqual($stock->highestPrice)
        ->toBeLessThanOrEqual($stock->openPrice)
        ->toBeLessThanOrEqual($stock->closePrice)
        ->and($stock->highestPrice)
        ->toBeGreaterThanOrEqual($stock->lowestPrice)
        ->toBeGreaterThanOrEqual($stock->openPrice)
        ->toBeGreaterThanOrEqual($stock->closePrice)
        ->and($stock->numberOfTransactions)
        ->toBeGreaterThanOrEqual(1);
})->with([now()->addWeeks(-1)->startOfWeek(), now()->addWeeks(-1)->startOfWeek()->format('Y-m-d'), null]);

it('success collections', function () {
    expect(Stock::stock(null, now()->addWeeks(-1)->startOfWeek()))
        ->toBeObject()
        ->toBeInstanceOf(Collection::class)
        ->toContainOnlyInstancesOf(StockData::class)
        ->count()
        ->toBeGreaterThanOrEqual(10000);
});

it('failed weekend failed', function () {
    Stock::stock('TEAM', now()->addWeek(-1)->endOfWeek());
})->throws(ItemNotFoundException::class);

it('failed lower date', function () {
    Stock::stock('TEAM', now()->addYear(-4)->startOfWeek());
})->throws(InvalidDateException::class);

it('failed highest date', function () {
    Stock::stock('TEAM', now());
})->throws(InvalidDateException::class);

it('failed date format', function () {
    Stock::stock('TEAM', now()->format('Y-m-da'));
})->throws(InvalidDateException::class);
