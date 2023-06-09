<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api\Operation;

interface UploadableResourceInterface
{
    public function upload(array $data = [], array $options = []): void;
}
