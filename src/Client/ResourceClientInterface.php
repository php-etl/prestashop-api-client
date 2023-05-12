<?php

namespace Kiboko\Component\Prestashop\ApiClient\Client;

interface ResourceClientInterface
{
    public function getResources(string $resource, array $options = []): \Iterator;
    public function getResource(string $resource, int $id = null, array $options = []): array;
    public function createResource(string $resource, array $data = [], array $options = []): array;
    public function updateResource(string $resource, array $data = [], array $options = []): array;
    public function upsertResource(string $resource, array $data = [], array $options = [], string $identifier = 'id'): array;
}
