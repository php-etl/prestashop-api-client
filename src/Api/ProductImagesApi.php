<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;

final class ProductImagesApi implements ProductImagesApiInterface
{
    public function __construct(
        private ResourceClientInterface $resourceClient,
    ) {
    }

    public function get($code, array $options = []): array
    {
        return $this->resourceClient->getResource('images/products', $code, $options);
    }

    public function upload(array $data = [], array $options = []): array
    {
        return $this->resourceClient->uploadResource('images/products', $data, $options);
    }
}
