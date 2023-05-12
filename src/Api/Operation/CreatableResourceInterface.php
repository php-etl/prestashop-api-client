<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api\Operation;

interface CreatableResourceInterface
{
    public function create(array $data = [], array $options = []): array;
}
