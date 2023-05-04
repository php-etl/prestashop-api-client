<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Client;

use Kiboko\Component\Prestashop\ApiClient\Exception\InvalidArgumentException;
use Kiboko\Component\Prestashop\ApiClient\Exception\NotFoundException;
use Kiboko\Component\Prestashop\ApiClient\Exception\ServerException;
use Kiboko\Component\Prestashop\ApiClient\Exception\WebserviceException;
use Symfony\Component\Serializer\Serializer;

class ResourceClient implements ResourceClientInterface
{
    public function __construct(
        private readonly \PrestaShopWebservice $client,
        private readonly Serializer $serializer,
    ) {}

    /**
     * @throws ServerException|WebserviceException
     */
    public function getResources(string $resource, array $options = []): \Iterator
    {
        $options['resource'] = $resource;
        $options['display'] = $options['display'] ?? 'full';
        $options['date'] = '1';

        try {
            $results = $this->xmlToArray($this->client->get($options)->asXML());
        } catch (\PrestaShopWebserviceServerException $e) {
            throw new ServerException('Error coming from the server: '.$e->getMessage(), $e->getCode());
        } catch (\PrestaShopWebserviceClientException $e) {
            throw new WebserviceException('Error coming from the Webservice: '.$e->getMessage(), $e->getCode());
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode());
        }

        if (!array_key_exists($resource, $results)) {
            throw new ServerException('Prestashop response is formatted in an unexpected way :'.json_encode($results));
        }

        if (!is_array($results[$resource])) { // no results
            return;
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

    /**
     * @throws WebserviceException
     */
    public function getResource(string $resource, $id = null, array $options = []): array
    {
        $options['resource'] = $resource;

        if ($id) {
            $options['id'] = (int)$id;
        }

        try {
            return $this->xmlToArray($this->client->get($options)->asXML());
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws WebserviceException
     */
    public function createResource(string $resource, array $data = [], array $options = []): void
    {
        $options['resource'] = $resource;
        $options['postXml'] = $this->arrayToXml([$resource => $data]);

        try {
            $this->client->add($options);
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws InvalidArgumentException|NotFoundException|WebserviceException
     */
    public function updateResource(string $resource, array $data = [], array $options = []): void
    {
        if (!is_array($data) || !array_key_exists('id', $data)) {
            throw new InvalidArgumentException('Attempting to update, but no id was found in the payload.');
        }

        $options['resource'] = $resource;
        $options['id'] = (int)$data['id'];
        $options['putXml'] = $this->arrayToXml([$resource => $data]);

        try {
            $this->client->edit($options);
        } catch (\PrestaShopWebserviceNotFoundException) {
            throw new NotFoundException(sprintf('No %s found with id "%d"', $resource, $options['id']));
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws WebserviceException|InvalidArgumentException
     */
    public function upsertResource(string $resource, array $data = [], array $options = []): void
    {
        try {
            $this->updateResource($resource, $data, $options);
        } catch (NotFoundException) {
            unset($data['id']);

            $this->createResource($resource, $data, $options);
        } catch (WebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode());
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
