<?php

namespace TheCaliskan\Stock\Exceptions;

use Carbon\Carbon;
use RuntimeException;

class InvalidDateException extends RuntimeException
{
    public static function getLowDate(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d', '2022-02-02', 'UTC');
    }

    public static function getHighDate(): Carbon
    {
        return now()->utc()->addDays(-1);
    }

    public static function dateTooLow(): self
    {
        return new self('StockData API can only be fetched for after or equal '.static::getLowDate()->format('Y-m-d').'.');
    }

    public static function dateTooHigh(): self
    {
        return new self('StockData API can only be fetched for before or equal '.static::getHighDate()->format('Y-m-d').'.');
    }

    public static function invalidDateFormat(): self
    {
        return new self("The date format should be 'Y-m-d'");
    }
}
