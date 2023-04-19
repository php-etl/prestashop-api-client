<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;

final class CombinationsApi implements CombinationsApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('combinations', $code, $options);
    }

    public function create(array $data = [], array $options = []): void
    {
        $this->resourceClient->createResource('combinations', $data, $options);
    }

    public function update(array $data = [], array $options = []): void
    {
        $this->resourceClient->updateResource('combinations', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): void
    {
        $this->resourceClient->upsertResource('combinations', $data, $options);
    }

    public function all(array $options = []): \Generator
    {
        return $this->resourceClient->getResources('combinations', $options);
    }
}
