<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;

final class StockAvailablesApi implements StockAvailablesApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('stock_availables', $code, $options);
    }

    public function update(array $data = [], array $options = []): void
    {
        $this->resourceClient->updateResource('stock_availables', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): void
    {
        $this->resourceClient->upsertResource('stock_availables', $data, $options);
    }

    public function all(array $options = []): \Generator
    {
        return $this->resourceClient->getResources('stock_availables', $options);
    }
}
