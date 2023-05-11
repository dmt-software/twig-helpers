<?php

namespace DMT\Twig\Tabular;

use Closure;
use Twig\Error\RuntimeError;

class Column
{
    protected string $name;
    /** @var string|callable|null $display */
    protected $display;
    protected iterable $attr = [];
    /** @var callable $content */
    protected $content;
    protected bool $sortable = false;

    private Tabular $parent;

    public function __construct(Tabular $parent, string $name)
    {
        $this->parent = $parent;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

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

    public function getAttr(): ?iterable
    {
        return $this->attr;
    }

    public function setAttr(iterable $attr): void
    {
        $this->attr = $attr;
    }

    public function isCustom(): bool
    {
        return null !== $this->content;
    }

    /**
     * @param object|array $row
     *
     * @return string
     */
    public function getContent($row): string
    {
        return call_user_func($this->content, $row);
    }

    public function setContent(Closure $content): void
    {
        $this->content = $content->bindTo($this);
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function setSortable(): void
    {
        $this->sortable = true;
    }

    /**
     * Get sorting url.
     *
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
