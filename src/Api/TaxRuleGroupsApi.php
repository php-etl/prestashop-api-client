<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;

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

    public function create(array $data = [], array $options = []): void
    {
        $this->resourceClient->createResource('tax_rule_groups', $data, $options);
    }

    public function update(array $data = [], array $options = []): void
    {
        $this->resourceClient->updateResource('tax_rule_groups', $data, $options);
    }

    public function upsert(array $data = [], array $options = []): void
    {
        $this->resourceClient->upsertResource('tax_rule_groups', $data, $options);
    }

    public function all(array $options = []): \Generator
    {
        return $this->resourceClient->getResources('tax_rule_groups', $options);
    }
}
