<?php

namespace TheCaliskan\Stock\Enums;

use Carbon\Carbon;

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
}
