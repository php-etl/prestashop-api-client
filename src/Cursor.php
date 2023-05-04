<?php

declare(strict_types=1);

namespace Kiboko\Component\Prestashop\ApiClient;

use Kiboko\Component\Prestashop\ApiClient\Client\ResourceClientInterface;

final class Cursor implements \Iterator
{
    private \Iterator $currentPage;
    private int $offset = 0;

    public function __construct(
        private readonly ResourceClientInterface $client,
        private readonly string $resource,
        private readonly int $pageSize = 10,
        private readonly array $options = [],
    ) {
        $this->currentPage = new \EmptyIterator();
    }

    private function fetchNextPage(): void
    {
        $this->currentPage = $this->client->getResources($this->resource, $this->options + [
            'limit' => $this->offset.','.$this->pageSize,
        ]);

        $this->offset += $this->pageSize;
    }

    private function assertCurrentItem(): void
    {
        if ($this->currentPage->valid()) {
            return;
        }

        if ($this->currentPage instanceof \EmptyIterator) {
            return;
        }

        $this->fetchNextPage();

        if (!$this->currentPage->valid()) {
            $this->currentPage = new \EmptyIterator();
        }
    }

    public function rewind(): void
    {
        $this->fetchNextPage();
        $this->currentPage->rewind();
    }

    public function current(): mixed
    {
        $this->assertCurrentItem();

        return $this->currentPage->current();
    }

    public function next(): void
    {
        $this->currentPage->next();
    }

    public function key(): mixed
    {
        $this->assertCurrentItem();

        return $this->currentPage->key();
    }

    public function valid(): bool
    {
        $this->assertCurrentItem();

        return $this->currentPage->valid();
    }
}