<?php

use Illuminate\Support\Facades\Cache;
use TheCaliskan\Stock\Stock;
use TheCaliskan\Stock\StockClient;

beforeEach(function () {
    $this->stock = new Stock(new StockClient(Cache::driver()));
});

it('can test', function () {
    expect(true)->toBeTrue();
});
