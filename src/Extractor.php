<?php

declare(strict_types=1);

namespace Kiboko\Component\Flow\Prestashop;

use Kiboko\Component\Bucket\AcceptanceResultBucket;
use Kiboko\Contract\Pipeline\ExtractorInterface;
use Symfony\Component\HttpFoundation\Request;

class Extractor implements ExtractorInterface
{
    public function __construct(
        private readonly Client $client,
        private readonly array $options = []
    ) {
    }

    public function extract(): iterable
    {
        $options = $this->options;

        $url = $this->client->password.'@'.$this->client->url.'/api/'.$options['resource'];

        if (isset($options['id'])) {
            $url .= '/' . $options['id'];
        }

        $options = array_replace(
            $options,
            [
                'resource' => null,
                'id' => null,
                'output_format' => 'JSON'
            ]
        );

        $request = Request::create(uri: $url, parameters: $options);

        foreach ($request->toArray() as $content) {
            yield new AcceptanceResultBucket($content);
        }
    }
}
