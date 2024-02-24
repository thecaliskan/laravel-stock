<?php

namespace TheCaliskan\Stock;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Collection;
use TheCaliskan\Stock\Data\CryptoData;
use TheCaliskan\Stock\Data\ForexData;
use TheCaliskan\Stock\Data\StockData;
use TheCaliskan\Stock\Enums\TypeEnum;
use TheCaliskan\Stock\Exceptions\InvalidDateException;

class Stock
{
    public function __construct(
        protected StockClient $stockClient
    ) {

    }

    /**
     * @return Collection<int,StockData>|StockData
     *
     * @throw ItemNotFoundException
     */
    public function stock(?string $symbol = null, Carbon|string|null $date = null): Collection|StockData
    {
        $collection = StockData::collect($this->getData(TypeEnum::Stock, $date, $symbol), Collection::class);

        return is_null($symbol) ? $collection : $collection->sole('symbol', $symbol);
    }

    /**
     * @return Collection<int,ForexData>|ForexData
     *
     * @throw ItemNotFoundException
     */
    public function forex(?string $symbol = null, Carbon|string|null $date = null): Collection|ForexData
    {
        $collection = ForexData::collect($this->getData(TypeEnum::Forex, $date, $symbol), Collection::class);

        return is_null($symbol) ? $collection : $collection->sole('symbol', $symbol);
    }

    /**
     * @return Collection<int,CryptoData>|CryptoData
     *
     * @throw ItemNotFoundException
     */
    public function crypto(?string $symbol = null, Carbon|string|null $date = null): Collection|CryptoData
    {
        $collection = CryptoData::collect($this->getData(TypeEnum::Crypto, $date, $symbol), Collection::class);

        return is_null($symbol) ? $collection : $collection->sole('symbol', $symbol);
    }

    protected function getData(TypeEnum $typeEnum, Carbon|string|null $date = null, ?string $symbol = null): array
    {
        if (is_string($date)) {
            try {
                $date = Carbon::createFromFormat('Y-m-d', $date);

                if (! $date) {
                    throw InvalidDateException::invalidDateFormat(); //@codeCoverageIgnore
                } else {
                    $date = $date->utc();
                }
            } catch (InvalidFormatException $exception) {
                throw InvalidDateException::invalidDateFormat();
            }
        }

        if ($date instanceof Carbon) {
            if ($date < InvalidDateException::getLowDate()) {
                throw InvalidDateException::dateTooLow();
            } elseif ($date > InvalidDateException::getHighDate()) {
                throw InvalidDateException::dateTooHigh();
            }
        } else {
            $date = $this->stockClient->latest($typeEnum);
        }

        $results = $this->stockClient->getStockData($typeEnum, $date);

        return is_null($symbol) ? $results : array_filter($results, fn ($result) => $result['T'] == $symbol);
    }
}
