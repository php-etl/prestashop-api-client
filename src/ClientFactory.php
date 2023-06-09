<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClient;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;

final class ClientFactory
{
    public function buildClient(string $url, string $apiKey): PrestashopClient
    {
        $resourceClient = new ResourceClient(
            new \PrestaShopWebservice($url, $apiKey, false),
            new Serializer([new ArrayDenormalizer()], [new XmlEncoder()])
        );

        $client = new PrestashopClient(
            new Api\CategoriesApi($resourceClient),
            new Api\CombinationsApi($resourceClient),
            new Api\ManufacturersApi($resourceClient),
            new Api\ProductFeaturesApi($resourceClient),
            new Api\ProductFeatureValuesApi($resourceClient),
            new Api\ProductImagesApi($resourceClient),
            new Api\ProductOptionsApi($resourceClient),
            new Api\ProductOptionValuesApi($resourceClient),
            new Api\ProductsApi($resourceClient),
            new Api\ShopsApi($resourceClient),
            new Api\StockAvailablesApi($resourceClient),
            new Api\SuppliersApi($resourceClient),
            new Api\TaxRuleGroupsApi($resourceClient),
            new Api\TaxRulesApi($resourceClient),
        );

        return $client;
    }
}
