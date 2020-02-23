<?php

namespace DMT\Twig\Tabular;

use Twig\Error\RuntimeError;

/**
 * Class Column
 *
 * @package DMT\Twig\Tabular
 * @author Bas de Mes <bas@dmt-software.nl>
 */
class Column
{
    /** @var string $name */
    protected $name;

    /** @var string|callable|null $display */
    protected $display;

    /** @var iterable $attr */
    protected $attr = [];

    /** @var bool $sortable */
    protected $sortable = false;

    /** @var Tabular $parent */
    private $parent;

    /**
     * Column constructor.
     *
     * @param Tabular $parent
     * @param string $name
     */
    public function __construct(Tabular $parent, string $name)
    {
        $this->parent = $parent;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDisplay(): string
    {
        return $this->display ?? $this->name;
    }

    /**
     * @param string|callable|null $display
     */
    public function setDisplay($display): void
    {
        $this->display = $display;
    }

    /**
     * @return iterable|null
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
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     *
     */
    public function setSortable(): void
    {
        $this->sortable = true;
    }

    /**
     * Get sorting url.
     *
     * @return string
     * @throws RuntimeError
     */
    public function getSortingUrl(): string
    {
        if (!$this->parent->getMetadata()) {
            throw new RuntimeError('No metadata set to for rendering a sorting url');
        }

        return $this->parent->getMetadata()->getSortingUrl($this);
    }
}
