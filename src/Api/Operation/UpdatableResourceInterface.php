<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api\Operation;

interface UpdatableResourceInterface
{
    public function update(array $data = [], array $options = []): void;
}
