<?php

namespace DMT\Twig\Tabular;

use Iterator;

class Table
{
    /**
     * The title of the table.
     *
     * This will be displayed as <caption>.
     *
     * @var string $title
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
     * @var iterable|Column[] $columns
     */
    protected $columns;

    /**
     * The result set
     *
     * These will be displayed within the <tbody>
     *
     * @var Iterator $resultSet
     */
    protected $resultSet;

    /**
     * The location of the twig template to use.
     *
     * @var string $theme
     */
    protected $theme;

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return iterable
     */
    public function getAttr(): ?iterable
    {
        return $this->attr;
    }

    /**
     * @return Column[]|iterable
     */
    public function getColumns(): ?iterable
    {
        return $this->columns;
    }

    /**
     * @return Iterator
     */
    public function getResultSet(): ?Iterator
    {
        return $this->resultSet;
    }
}