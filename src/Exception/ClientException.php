<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Exception;

class ClientException extends \Exception
{
    public function __construct($message = "", $code = 0, $previous = null)
    {
        return parent::__construct('Error coming from the Webservice: '. $message, $code, $previous);
    }
}