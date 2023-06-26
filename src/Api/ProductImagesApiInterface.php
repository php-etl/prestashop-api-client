<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api;

use Kiboko\Component\Prestashop\ApiClient\Api\Operation\GettableResourceInterface;
use Kiboko\Component\Prestashop\ApiClient\Api\Operation\UploadableResourceInterface;

interface ProductImagesApiInterface extends UploadableResourceInterface, GettableResourceInterface
{
}
