<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Exception;

class NoUniqueIdentifierInPayloadException extends \Exception
{
    public function __construct(string $resource, string $pathInPayload, $code = 0, $previous = null)
    {
        return parent::__construct(
            sprintf('Attempted to upsert on entity "%s". The payload should have a unique discriminator under %s, but no value could be found.', $resource, $pathInPayload),
            $code,
            $previous
        );
    }
}