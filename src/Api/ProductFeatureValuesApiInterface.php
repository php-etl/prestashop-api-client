<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Api\Operation\CreatableResourceInterface;
use Kiboko\Component\Prestashop\ApiClient\Api\Operation\GettableResourceInterface;
use Kiboko\Component\Prestashop\ApiClient\Api\Operation\ListableResourceInterface;
use Kiboko\Component\Prestashop\ApiClient\Api\Operation\UpdatableResourceInterface;
use Kiboko\Component\Prestashop\ApiClient\Api\Operation\UpsertableResourceInterface;

interface ProductFeatureValuesApiInterface extends GettableResourceInterface, ListableResourceInterface, CreatableResourceInterface, UpdatableResourceInterface, UpsertableResourceInterface
{
}
