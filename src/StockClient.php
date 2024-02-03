<?php

namespace TheCaliskan\Stock;

use Carbon\Carbon;
use CurlHandle;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Str;
use TheCaliskan\Stock\Enums\TypeEnum;
use TheCaliskan\Stock\Exceptions\ClientException;

class StockClient
{
    /** @var ?CurlHandle */
    protected ?CurlHandle $curlHandle = null;

    public function __construct(
        protected Repository $cache,
    ) {
    }

    public function __destruct()
    {
        if ($this->curlHandle) {
            curl_close($this->curlHandle);
            $this->curlHandle = null;
        }
    }

    public function latest(TypeEnum $typeEnum): Carbon
    {
        $response = $this->cache->remember(
            key: 'stock:latest',
            ttl: 60,
            callback: fn () => $this->get('latest.json')
        );

        return Carbon::createFromFormat('Y-m-d', $response[Str::lower($typeEnum->name)], 'UTC');
    }

    public function getStockData(TypeEnum $typeEnum, Carbon $date): array
    {
        return $this->cache->remember(
            key: 'stock:'.$typeEnum->lower().':'.$date->format('Y-m-d'),
            ttl: 60 * 60 * 24,
            callback: fn () => $this->get($typeEnum->path($date))['results']
        );
    }

    public function get(string $path): array
    {
        $curlHandle = $this->getCurlHandle('https://raw.githubusercontent.com/thecaliskan/stock-data/master/'.$path);

        /**
         * @var string $response
         */
        $response = curl_exec($curlHandle);

        if (curl_errno($curlHandle)) {
            $curlError = curl_error($curlHandle);

            throw ClientException::unexpectedResponse($curlError);
        }

        /**
         * @var array<string,string|int|float> $responseArray
         */
        $responseArray = json_decode($response, true);

        if (($responseArray['status'] ?? '') != 'OK') {
            throw ClientException::unexpectedResponse($response);
        }

        return $responseArray;
    }

    protected function getCurlHandle(string $fullUrl): CurlHandle
    {
        if (! $this->curlHandle) {
            $this->curlHandle = curl_init();
        }

        curl_reset($this->curlHandle);
        curl_setopt($this->curlHandle, CURLOPT_URL, $fullUrl);

        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, array_merge([
            'Accept: application/json',
            'Content-Type: application/json',
        ]));

        curl_setopt($this->curlHandle, CURLOPT_USERAGENT, 'Laravel StockData 1.0');
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curlHandle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, 5);
        curl_setopt($this->curlHandle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($this->curlHandle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($this->curlHandle, CURLOPT_ENCODING, '');
        curl_setopt($this->curlHandle, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->curlHandle, CURLOPT_FAILONERROR, true);

        return $this->curlHandle;
    }
}
