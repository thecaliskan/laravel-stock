<?php

namespace TheCaliskan\Stock\Facades;

use Carbon\Carbon;
use Illuminate\Support\Facades\Facade;
use Spatie\LaravelData\DataCollection;
use TheCaliskan\Stock\Data\CryptoData;
use TheCaliskan\Stock\Data\ForexData;
use TheCaliskan\Stock\Data\StockData;

/**
 * @method static DataCollection|StockData stock(?string $symbol = null, Carbon|string|null $date = null)
 * @method static DataCollection|ForexData forex(?string $symbol = null, Carbon|string|null $date = null)
 * @method static DataCollection|CryptoData crypto(?string $symbol = null, Carbon|string|null $date = null)
 *
 * @see \TheCaliskan\Stock\Stock
 */
class Stock extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TheCaliskan\Stock\Stock::class;
    }
}
