<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;
use Kiboko\Component\Prestashop\ApiClient\Cursor;

final class ProductOptionsApi implements ProductOptionsApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('product_options', $code, $options);
    }

    public function create(array $data = [], array $options = []): array
    {
        return $this->resourceClient->createResource('product_options', $data, $options);
    }

    public function update(array $data = [], array $options = []): array
    {
        return $this->resourceClient->updateResource('product_options', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): array
    {
        return $this->resourceClient->upsertResource('product_options', $data, $options);
    }

    public function all(array $options = []): \Traversable
    {
        return new Cursor($this->resourceClient, 'product_options', options: $options);
    }
}
