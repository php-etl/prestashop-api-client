<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Exception;

class MaybeForbiddenException extends \Exception
{
    public function __construct($message = "", $code = 0, $previous = null)
    {
        return parent::__construct('The webservice responded with the following message, but make sure your API key is correct: '.$message, $code, $previous);
    }
}