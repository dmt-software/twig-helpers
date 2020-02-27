<?php

namespace DMT\Twig\Metadata;

use DMT\Twig\Tabular\Column;
use DMT\Twig\Tabular\MetadataInterface as TabularMetadata;
use Psr\Http\Message\UriInterface;

/**
 * Class QuerystringMetadata
 *
 * @package DMT\Twig\Metadata
 * @author Bas de Mes <bas@dmt-software.nl>
 */
class QuerystringMetadata implements TabularMetadata
{
    /** @var UriInterface $requestUri */
    protected $requestUri;

    /** @var string $sort */
    protected $sort;

    /** @var string $order */
    protected $order;

    /**
     * QueryStringMetadata constructor.
     *
     * @param UriInterface $requestUri
     */
    public function __construct(UriInterface $requestUri)
    {
        $this->requestUri = $requestUri;
        $this->parseQueryString();
    }

    /**
     * {@inheritDoc}
     */
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

    /**
     * Parse the querystring into parameters
     */
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
