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
     *
     * @return $this
     */
    public function setDisplay($display): self
    {
        $this->display = $display;

        return $this;
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
     *
     * @return $this
     */
    public function setAttr(iterable $attr): self
    {
        $this->attr = $attr;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @return $this
     */
    public function setSortable(): self
    {
        $this->sortable = true;

        return $this;
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
