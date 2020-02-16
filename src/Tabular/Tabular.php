<?php

namespace DMT\Twig\Tabular;

use ArrayIterator;
use Traversable;

/**
 * Class Table
 *
 * @package DMT\Twig\Tabular
 * @author Bas de Mes <bas@dmt-software.nl>
 */
class Tabular
{
    /**
     * The title of the table.
     *
     * This will be displayed as <caption>.
     *
     * @var string|null $title
     */
    protected $title;

    /**
     * The attributes of the table.
     *
     * This will be displayed as element attributes (e.g. class)
     *
     * @var iterable $attr
     */
    protected $attr = [];

    /**
     * The columns for the table.
     *
     * These will be displayed within the <thead>.
     *
     * @var iterable|Column[]|null $columns
     */
    protected $columns;

    /**
     * The table metadata.
     *
     * This will be used for paging and sorting.
     *
     * @var MetadataInterface $metadata
     */
    protected $metadata;

    /**
     * The result set
     *
     * These will be displayed within the <tbody>
     *
     * @var Traversable $resultSet
     */
    protected $resultSet;

    /**
     * The location of the twig template to use.
     *
     * @var string $theme
     */
    protected $theme = '@tabular/default-table.twig';

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return iterable
     */
    public function getAttr(): ?iterable
    {
        return $this->attr;
    }

    /**
     * @param iterable $attr
     */
    public function setAttr(iterable $attr): void
    {
        $this->attr = $attr;
    }

    /**
     * @return Column[]|iterable
     */
    public function getColumns(): ?iterable
    {
        return $this->columns;
    }

    /**
     * @param Column[]|iterable|null $columns
     *
     * @return Tabular
     */
    public function setColumns(?iterable $columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @return MetadataInterface
     */
    public function getMetadata(): ?MetadataInterface
    {
        return $this->metadata;
    }

    /**
     * @param MetadataInterface $metadata
     *
     * @return $this
     */
    public function setMetadata(MetadataInterface $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Column|null
     */
    public function getColumn(string $name): ?Column
    {
        return $this->columns[$name] ?? null;
    }

    /**
     * @param Column $column
     *
     * @return $this
     */
    public function setColumn(Column $column): self
    {
        $this->columns[$column->getName()] = $column;

        return $this;
    }

    /**
     * @return Traversable
     */
    public function getResultSet(): ?Traversable
    {
        return $this->resultSet;
    }

    /**
     * @param iterable $resultSet
     *
     * @return $this
     */
    public function setResultSet(iterable $resultSet): self
    {
        if (is_array($resultSet)) {
            $resultSet = new ArrayIterator($resultSet);
        }

        $this->resultSet = $resultSet;

        return $this;
    }

    /**
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     *
     * @return $this
     */
    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }
}
