<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api\Operation;

interface ListableResourceInterface
{
    public function all(array $options = []): \Traversable;
}
