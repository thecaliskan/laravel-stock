<?php

namespace TheCaliskan\Stock\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;
use TheCaliskan\Stock\Normalizers\TimestampMillisecondNormalizer;

class ForexData extends Data
{
    public function __construct(
        #[MapInputName('T')]
        public string $symbol,
        #[MapInputName('o')]
        public float $openPrice,
        #[MapInputName('c')]
        public float $closePrice,
        #[MapInputName('l')]
        public float $lowestPrice,
        #[MapInputName('h')]
        public float $highestPrice,
        #[MapInputName('n')]
        public int|Optional $numberOfTransactions,
        #[WithCast(DateTimeInterfaceCast::class, format: 'U', setTimeZone: 'UTC')]
        #[MapInputName('t')]
        public Carbon $timestamp,
        #[MapInputName('v')]
        public float $volume,
        #[MapInputName('vw')]
        public float|Optional $volumeWeightedAveragePrice,
    ) {
    }

    public static function normalizers(): array
    {
        return array_merge([
            TimestampMillisecondNormalizer::class,
        ], config('data.normalizers'));
    }
}
