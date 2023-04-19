<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api\Operation;

interface GettableResourceInterface
{
    public function get(int $code, array $options = []): array;
}
