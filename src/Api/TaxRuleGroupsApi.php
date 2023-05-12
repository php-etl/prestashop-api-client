<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;
use Kiboko\Component\Prestashop\ApiClient\Cursor;

final class TaxRuleGroupsApi implements TaxRuleGroupsApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('tax_rule_groups', $code, $options);
    }

    public function create(array $data = [], array $options = []): array
    {
        return $this->resourceClient->createResource('tax_rule_groups', $data, $options);
    }

    public function update(array $data = [], array $options = []): array
    {
        return $this->resourceClient->updateResource('tax_rule_groups', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): array
    {
        return $this->resourceClient->upsertResource('tax_rule_groups', $data, $options);
    }

    public function all(array $options = []): \Traversable
    {
        return new Cursor($this->resourceClient, 'tax_rule_groups', options: $options);
    }
}
