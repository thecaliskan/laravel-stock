<?php

namespace TheCaliskan\Stock\Exceptions;

use RuntimeException;

class ClientException extends RuntimeException
{
    public static function unexpectedResponse(string $response): self
    {
        return new self('An unexpected response came from the stock API: '.$response);
    }
}
