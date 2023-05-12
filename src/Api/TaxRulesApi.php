<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;
use Kiboko\Component\Prestashop\ApiClient\Cursor;

final class TaxRulesApi implements TaxRulesApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('tax_rules', $code, $options);
    }

    public function create(array $data = [], array $options = []): array
    {
        return $this->resourceClient->createResource('tax_rules', $data, $options);
    }

    public function update(array $data = [], array $options = []): array
    {
        return $this->resourceClient->updateResource('tax_rules', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): array
    {
        return $this->resourceClient->upsertResource('tax_rules', $data, $options);
    }

    public function all(array $options = []): \Traversable
    {
        return new Cursor($this->resourceClient, 'tax_rules', options: $options);
    }
}
