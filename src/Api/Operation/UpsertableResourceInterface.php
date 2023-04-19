<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api\Operation;

interface UpsertableResourceInterface
{
    public function upsert(array $data = [], array $options = []): void;
}
