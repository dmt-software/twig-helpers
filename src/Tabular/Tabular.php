<?php

namespace DMT\Twig\Tabular;

use ArrayIterator;
use Traversable;

class Tabular
{
    /**
     * The title of the table.
     *
     * This will be displayed as <caption>.
     */
    protected ?string $title = null;

    /**
     * The attributes of the table.
     *
     * This will be displayed as element attributes (e.g. class)
     */
    protected iterable $attr = [];

    /**
     * The columns for the table.
     *
     * These will be displayed within the <thead>.
     *
     * @var iterable|Column[]|null $columns
     */
    protected ?iterable $columns = null;

    /**
     * The table metadata.
     *
     * This will be used for paging and sorting.
     */
    protected ?MetadataInterface $metadata = null;

    /**
     * The result set
     *
     * These will be displayed within the <tbody>
     */
    protected Traversable $resultSet;

    /**
     * The location of the twig template to use.
     */
    protected string $template = '@tabular/default-table.twig';

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAttr(): ?iterable
    {
        return $this->attr;
    }

    public function setAttr(iterable $attr): void
    {
        $this->attr = $attr;
    }

    public function getMetadata(): ?MetadataInterface
    {
        return $this->metadata;
    }

    public function setMetadata(MetadataInterface $metadata): void
    {
        $this->metadata = $metadata;
    }

    public function getColumns(): ?iterable
    {
        return $this->columns;
    }

    public function getColumn(string $name): ?Column
    {
        return $this->columns[$name] ?? null;
    }

    public function setColumn(Column $column): void
    {
        $this->columns[$column->getName()] = $column;
    }

    public function getResultSet(): ?Traversable
    {
        return $this->resultSet;
    }

    public function setResultSet(iterable $resultSet): void
    {
        if (is_array($resultSet)) {
            $resultSet = new ArrayIterator($resultSet);
        }

        $this->resultSet = $resultSet;
    }
}
