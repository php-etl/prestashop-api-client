<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Exception;

class BadParametersException extends \Exception
{
    public function __construct($message = "", $code = 0, $previous = null)
    {
        return parent::__construct($message, $code, $previous);
    }
}