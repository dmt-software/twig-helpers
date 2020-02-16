<?php

namespace DMT\Twig\Tabular\Metadata;

use DMT\Twig\Tabular\Column;
use DMT\Twig\Tabular\MetadataInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class QuerystringMetadata
 *
 * @package DMT\Twig\Tabular
 * @author Bas de Mes <bas@dmt-software.nl>
 */
class QuerystringMetadata implements MetadataInterface
{
    /** @var UriInterface $requestUri */
    protected $requestUri;

    /** @var string $sort */
    protected $sort;

    /** @var string $order */
    protected $order;

    /** @var int $page */
    protected $page;

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
     * {@inheritDoc}
     */
    public function getPagingUrl(int $page): string
    {
        $sort = $this->sort;
        $order = $this->order;

        return (string) $this->requestUri
            ->withQuery(http_build_query(compact('page', 'sort', 'order')));
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
