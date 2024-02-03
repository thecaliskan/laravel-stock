<?php

namespace TheCaliskan\Stock\Enums;

use Carbon\Carbon;
use TheCaliskan\Stock\Data\CryptoData;
use TheCaliskan\Stock\Data\ForexData;
use TheCaliskan\Stock\Data\StockData;

enum TypeEnum
{
    case Stock;
    case Forex;
    case Crypto;

    public function lower(): string
    {
        return strtolower($this->name);
    }

    public function path(Carbon $date): string
    {
        return $this->lower().'/'.$date->format('Y-m-d').'.json';
    }

    public function data(): string
    {
        return match ($this) {
            self::Stock => StockData::class,
            self::Forex => ForexData::class,
            self::Crypto => CryptoData::class,
        };
    }
}
