<?php

namespace Kiboko\Component\Prestashop\ApiClient\Api\Operation;

interface DeletableResourceInterface
{
    public function delete($code): int;
}
