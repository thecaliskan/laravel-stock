<?php

namespace TheCaliskan\Stock\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TheCaliskan\Stock\Stock
 */
class Stock extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TheCaliskan\Stock\Stock::class;
    }
}
