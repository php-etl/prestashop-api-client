<?php

declare(strict_types=1);

namespace Kiboko\Component\Flow\Prestashop;

final class Client
{
    public function __construct(
        public string $url,
        public string $password,
    ) {
    }
}
