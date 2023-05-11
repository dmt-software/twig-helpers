<?php

namespace DMT\Twig\Metadata;

use DMT\Twig\Tabular\Column;
use DMT\Twig\Tabular\MetadataInterface as TabularMetadata;
use Psr\Http\Message\UriInterface;

class QueryStringMetadata implements TabularMetadata
{
    protected UriInterface $requestUri;
    protected ?string $sort = null;
    protected ?string $order = null;

    public function __construct(UriInterface $requestUri)
    {
        $this->requestUri = $requestUri;
        $this->parseQueryString();
    }

    public function getSortingUrl(Column $column): string
    {
        $sort = $column->getName();
        $order = 'asc';

        if ($this->sort === $sort && $this->order === 'asc') {
            $order = 'desc';
        }

        return (string) $this->requestUri
            ->withQuery(http_build_query(compact('sort', 'order')));
    }

    protected function parseQueryString(): void
    {
        parse_str($this->requestUri->getQuery(), $queryParams);

        foreach ($queryParams as $param => $value) {
            if (property_exists($this, $param)) {
                $this->{$param} = $value;
            }
        }
    }
}
