<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;

final class ProductFeaturesApi implements ProductFeaturesApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('product_features', $code, $options);
    }

    public function create(array $data = [], array $options = []): void
    {
        $this->resourceClient->createResource('product_features', $data, $options);
    }

    public function update(array $data = [], array $options = []): void
    {
        $this->resourceClient->updateResource('product_features', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): void
    {
        $this->resourceClient->upsertResource('product_features', $data, $options);
    }

    public function all(array $options = []): \Generator
    {
        return $this->resourceClient->getResources('product_features', $options);
    }
}
