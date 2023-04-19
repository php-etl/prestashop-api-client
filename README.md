# PrestaShop API Client

A PHP client that uses the [Prestashop API](https://devdocs.prestashop-project.org/8/webservice/).

Compatibility matrix:

| Prestashop version(s) | php-etl Client version | PHP requirements | CI status |
|-----------------------|------------------------|------------------|-----------|
| 8.1.0                 | ^0.1 (master)          | ^8.2             |           |

### API usage

```php
<?php

$builder = new \Kiboko\Component\Prestashop\ApiClient\ClientFactory();

$client = $builder->buildClient('http://example-prestashop.com', 'WEBSERVICE_KEY12345');
$client->getProductsApi()->all();
```