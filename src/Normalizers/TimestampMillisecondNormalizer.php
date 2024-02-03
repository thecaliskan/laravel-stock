<?php

namespace TheCaliskan\Stock\Normalizers;

use Spatie\LaravelData\Normalizers\Normalizer;

class TimestampMillisecondNormalizer implements Normalizer
{
    /**
     * @param  array  $value
     */
    public function normalize(mixed $value): ?array
    {
        $value['t'] = (int) substr($value['t'], 0, -3);

        return $value;
    }
}
