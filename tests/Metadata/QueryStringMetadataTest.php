<?php

namespace DMT\Test\Twig\Metadata;

use DMT\Twig\Metadata\QueryStringMetadata;
use DMT\Twig\Tabular\Column;
use DMT\Twig\Tabular\Tabular;
use GuzzleHttp\Psr7\Uri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;

class QueryStringMetadataTest extends TestCase
{
    /**
     * @dataProvider sortableColumnProvider
     */
    public function testSortingUrl(UriInterface $uri, Column $column, string $expected)
    {
        $metadata = new QueryStringMetadata($uri);
        $this->assertSame($expected, $metadata->getSortingUrl($column));
    }

    public function sortableColumnProvider(): iterable
    {
        return [
            'default sort on column' => [
                new Uri('http://example.com/path/?sort=foo'),
                new Column(new Tabular(), 'foo'),
                'http://example.com/path/?sort=foo&order=asc'
            ],
            'default reverse sort on column' => [
                new Uri('http://example.com/path/?sort=foo&order=asc'),
                new Column(new Tabular(), 'foo'),
                'http://example.com/path/?sort=foo&order=desc'
            ],
            'previous sort on other column' => [
                new Uri('http://example.com/path/?sort=bar'),
                new Column(new Tabular(), 'foo'),
                'http://example.com/path/?sort=foo&order=asc'
            ],
            'previous reverse sort on other column' => [
                new Uri('http://example.com/path/?sort=bar&order=desc'),
                new Column(new Tabular(), 'foo'),
                'http://example.com/path/?sort=foo&order=asc'
            ],
            'sort cleans out current page' => [
                new Uri('http://example.com/path/?sort=foo&offset=20&limit=10'),
                new Column(new Tabular(), 'foo'),
                'http://example.com/path/?sort=foo&order=asc'
            ]
        ];
    }
}
