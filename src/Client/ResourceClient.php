<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Client;

use Symfony\Component\Serializer\Serializer;

class ResourceClient implements ResourceClientInterface
{
    public function __construct(
        private readonly \PrestaShopWebservice $client,
        private readonly Serializer $serializer,
    ) {}

    public function getResources(string $resource, array $options = []): \Generator
    {
        $options['resource'] = $resource;
        $options['display'] = $options['display'] ?? 'full';

        $results = $this->xmlToArray(
            $this->client->get($options)->asXML()
        );

        if (!array_key_exists($resource, $results)) {
            throw new \Exception('Prestashop response is formatted in an unexpected way.');
        }

        if (!is_array($results[$resource])) { // no results
            return [];
        }

        // {"prestashop: {"products": { "product": {"id", "name"...}}}}
        foreach ($results[$resource] as $entity) {
            if (array_key_exists('id', $entity)) { // only one result (no array to loop into)
                yield $entity;
                break;
            }

            foreach ($entity as $data) {
                yield $data;
            }
        }
    }

    public function getResource(string $resource, $id = null, array $options = []): array
    {
        $options['resource'] = $resource;

        if ($id) {
            $options['id'] = (int)$id;
        }

        return $this->xmlToArray(
            $this->client->get($options)->asXML()
        );
    }

    public function createResource(string $resource, array $data = [], array $options = []): void
    {
        $options['resource'] = $resource;
        $options['postXml'] = $this->arrayToXml($data);

        $this->client->add($options);
    }

    public function updateResource(string $resource, array $data = [], array $options = []): void
    {
        $payload = reset($data);
        if (!is_array($payload) || !array_key_exists('id', $payload)) {
            throw new \Exception('No "id" found in the payload. Make sure the line is correctly formatted, with the resource\'s name at the top level. It should look like ["product" => ["id" => "123", ... ]] in case of a product creation.');
        }

        $options['resource'] = $resource;
        $options['putXml'] = $this->arrayToXml($data);
        $options['id'] = (int)$payload['id'];

        $this->client->edit($options);
    }

    public function upsertResource(string $resource, array $data = [], array $options = []): void
    {
        try {
            $this->updateResource($resource, $data, $options);
        } catch (\PrestaShopWebserviceNotFoundException) {
            unset($data[key($data)]['id']);

            $this->createResource($resource, $data, $options);
        }
    }

    private function xmlToArray(string $xml): array
    {
        return $this->serializer->decode($xml, 'xml');
    }

    private function arrayToXml(array $array): string
    {
        return $this->serializer->encode($array, 'xml');
    }
}
