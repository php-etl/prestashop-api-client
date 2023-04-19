<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;

final class ManufacturersApi implements ManufacturersApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('manufacturers', $code, $options);
    }

    public function create(array $data = [], array $options = []): void
    {
        $this->resourceClient->createResource('manufacturers', $data, $options);
    }

    public function update(array $data = [], array $options = []): void
    {
        $this->resourceClient->updateResource('manufacturers', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): void
    {
        $this->resourceClient->upsertResource('manufacturers', $data, $options);
    }

    public function all(array $options = []): \Generator
    {
        return $this->resourceClient->getResources('manufacturers', $options);
    }
}