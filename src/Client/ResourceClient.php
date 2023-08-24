<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient\Client;

use Kiboko\Component\Prestashop\ApiClient\Exception\BadParametersException;
use Kiboko\Component\Prestashop\ApiClient\Exception\BadRequestException;
use Kiboko\Component\Prestashop\ApiClient\Exception\ClientException;
use Kiboko\Component\Prestashop\ApiClient\Exception\ForbiddenException;
use Kiboko\Component\Prestashop\ApiClient\Exception\InvalidArgumentException;
use Kiboko\Component\Prestashop\ApiClient\Exception\MaybeForbiddenException;
use Kiboko\Component\Prestashop\ApiClient\Exception\MethodNotAllowedException;
use Kiboko\Component\Prestashop\ApiClient\Exception\NoContentException;
use Kiboko\Component\Prestashop\ApiClient\Exception\NotFoundException;
use Kiboko\Component\Prestashop\ApiClient\Exception\NoUniqueIdentifierInPayloadException;
use Kiboko\Component\Prestashop\ApiClient\Exception\ServerException;
use Kiboko\Component\Prestashop\ApiClient\Exception\StatusException;
use Kiboko\Component\Prestashop\ApiClient\Exception\TooManyRequestsException;
use Kiboko\Component\Prestashop\ApiClient\Exception\UnauthorizedException;
use Kiboko\Component\Prestashop\ApiClient\Exception\WebserviceException;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ResourceClient implements ResourceClientInterface
{
    public function __construct(
        private readonly \PrestaShopWebservice $client,
        private readonly Serializer $serializer,
    ) {}

    /**
     * @throws BadParametersException
     * @throws BadRequestException
     * @throws ClientException
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws NoContentException
     * @throws NotFoundException
     * @throws ServerException
     * @throws StatusException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws WebserviceException
     * @throws MaybeForbiddenException
     */
    public function getResources(string $resource, array $options = [], string|null $resourceName = null): \Iterator
    {
        $options['resource'] = $resource;
        $options['display'] = $options['display'] ?? 'full';
        $options['date'] = '1';

        try {
            $results = $this->xmlToArray($this->client->get($options)->asXML());
        } catch (\PrestaShopWebserviceMissingPreconditionException $e) {
            throw new MaybeForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceServerException $e) {
            throw new ServerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceClientException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceStatusException $e) {
            throw new StatusException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNoContentException $e) {
            throw new NoContentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceTooManyRequestsException $e) {
            throw new TooManyRequestsException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceMethodNotAllowedException $e) {
            throw new MethodNotAllowedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceForbiddenException $e) {
            throw new ForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceUnauthorizedException $e) {
            throw new UnauthorizedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadRequestException $e) {
            throw new BadRequestException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadParametersException $e) {
            throw new BadParametersException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        if ($resourceName) {
            $resource = $resourceName;
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
     * @throws BadParametersException
     * @throws BadRequestException
     * @throws ClientException
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws NoContentException
     * @throws NotFoundException
     * @throws ServerException
     * @throws StatusException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws WebserviceException
     * @throws MaybeForbiddenException
     */
    public function getResource(string $resource, $id = null, array $options = []): array
    {
        $options['resource'] = $resource;

        if ($id) {
            $options['id'] = (int)$id;
        }

        try {
            return $this->xmlToArray($this->client->get($options)->asXML());
        } catch (\PrestaShopWebserviceMissingPreconditionException $e) {
            throw new MaybeForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceServerException $e) {
            throw new ServerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceClientException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceStatusException $e) {
            throw new StatusException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNoContentException $e) {
            throw new NoContentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceTooManyRequestsException $e) {
            throw new TooManyRequestsException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceMethodNotAllowedException $e) {
            throw new MethodNotAllowedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceForbiddenException $e) {
            throw new ForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceUnauthorizedException $e) {
            throw new UnauthorizedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadRequestException $e) {
            throw new BadRequestException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadParametersException $e) {
            throw new BadParametersException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @throws BadParametersException
     * @throws BadRequestException
     * @throws ClientException
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws NoContentException
     * @throws NotFoundException
     * @throws ServerException
     * @throws StatusException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws WebserviceException
     * @throws MaybeForbiddenException
     */
    public function createResource(string $resource, array $data = [], array $options = []): array
    {
        $options['resource'] = $resource;
        $options['postXml'] = $this->arrayToXml([$resource => $data]);

        try {
            return $this->xmlToArray($this->client->add($options)->asXML());
        } catch (\PrestaShopWebserviceMissingPreconditionException $e) {
            throw new MaybeForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceServerException $e) {
            throw new ServerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceClientException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceStatusException $e) {
            throw new StatusException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNoContentException $e) {
            throw new NoContentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceTooManyRequestsException $e) {
            throw new TooManyRequestsException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceMethodNotAllowedException $e) {
            throw new MethodNotAllowedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceForbiddenException $e) {
            throw new ForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceUnauthorizedException $e) {
            throw new UnauthorizedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadRequestException $e) {
            throw new BadRequestException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadParametersException $e) {
            throw new BadParametersException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @throws BadParametersException
     * @throws BadRequestException
     * @throws ClientException
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws NoContentException
     * @throws NotFoundException
     * @throws ServerException
     * @throws StatusException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws WebserviceException
     * @throws InvalidArgumentException
     * @throws MaybeForbiddenException
     */
    public function updateResource(string $resource, array $data = [], array $options = []): array
    {
        if (!is_array($data) || !array_key_exists('id', $data)) {
            throw new InvalidArgumentException('Attempting to update, but no id was found in the payload.');
        }

        $options['resource'] = $resource;
        $options['id'] = (int)$data['id'];
        $options['putXml'] = $this->arrayToXml([$resource => $data]);

        try {
            return $this->xmlToArray($this->client->edit($options)->asXML());
        } catch (\PrestaShopWebserviceMissingPreconditionException $e) {
            throw new MaybeForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceServerException $e) {
            throw new ServerException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceClientException $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceStatusException $e) {
            throw new StatusException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNoContentException $e) {
            throw new NoContentException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceTooManyRequestsException $e) {
            throw new TooManyRequestsException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceMethodNotAllowedException $e) {
            throw new MethodNotAllowedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceNotFoundException $e) {
            throw new NotFoundException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceForbiddenException $e) {
            throw new ForbiddenException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceUnauthorizedException $e) {
            throw new UnauthorizedException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadRequestException $e) {
            throw new BadRequestException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceBadParametersException $e) {
            throw new BadParametersException($e->getMessage(), $e->getCode(), $e->getPrevious());
        } catch (\PrestaShopWebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

    /**
     * @throws BadParametersException
     * @throws BadRequestException
     * @throws ClientException
     * @throws ForbiddenException
     * @throws MethodNotAllowedException
     * @throws NoContentException
     * @throws NotFoundException
     * @throws ServerException
     * @throws StatusException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     * @throws WebserviceException
     * @throws InvalidArgumentException
     * @throws MaybeForbiddenException
     */
    public function upsertResource(string $resource, array $data = [], array $options = [], array $identifierPaths = ['[id]' => '[id]']): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $options['limit'] = 1;
        $options['filter'] = [];

        try {
            foreach ($identifierPaths as $pathInPayload => $pathInPrestashop) {
                $identifierValue = $propertyAccessor->getValue($data, $pathInPayload);
                if (null === $identifierValue) {
                    throw new NoUniqueIdentifierInPayloadException($resource, $pathInPayload);
                }

                $propertyAccessor->setValue($options['filter'], $pathInPrestashop, $identifierValue);
            }

            $existingEntity = $this->getResources($resource, $options)->current();
            if (null === $existingEntity) {
                throw new NotFoundException();
            }

            $data['id'] = $existingEntity['id'];
            return $this->updateResource($resource, $data, $options);
        } catch (NotFoundException|NoUniqueIdentifierInPayloadException) {
            unset($data['id']);
            return $this->createResource($resource, $data, $options);
        } catch (WebserviceException $e) {
            throw new WebserviceException($e->getMessage(), $e->getCode());
        }
    }

    public function uploadResource(string $resource, array $data = [], array $options = []): array
    {
        $options['resource'] = $resource;
        $options['id'] = (int)$data['id'];
        $options['image'] = $data['image'];
        return $this->client->upload($options);
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
