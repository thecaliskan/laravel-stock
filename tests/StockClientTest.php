<?php

use TheCaliskan\Stock\Exceptions\ClientException;
use TheCaliskan\Stock\Stock;
use TheCaliskan\Stock\StockClient;

it('failed curl error', function () {
    $cache = Mockery::mock(Illuminate\Cache\Repository::class)->makePartial();

    $cache->shouldReceive('get')
        ->andReturn(null);

    $stockClient = Mockery::mock(StockClient::class, [$cache])->makePartial();

    $stockClient->shouldReceive('latest')
        ->andReturn(now()->addDays(-3));

    $stockClient->shouldReceive('hasCurlError')
        ->andReturn(true);

    $stock = new Stock($stockClient);

    $stock->stock();
})->throws(ClientException::class);

it('failed broken response', function () {
    $cache = Mockery::mock(Illuminate\Cache\Repository::class)->makePartial();

    $cache->shouldReceive('get')
        ->andReturn(null);

    $stockClient = Mockery::mock(StockClient::class, [$cache])->makePartial();

    $stockClient->shouldReceive('latest')
        ->andReturn(now()->addDays(-3));

    $stockClient->shouldReceive('isSuccessResponse')
        ->andReturn(false);

    $stock = new Stock($stockClient);

    $stock->stock();
})->throws(ClientException::class);
