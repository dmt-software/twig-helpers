<?php

namespace DMT\Twig\Tabular;

/**
 * Class Builder
 *
 * @package DMT\Twig\Tabular
 * @author Bas de Mes <bas@dmt-software.nl>
 */
class Builder
{
    /** @var Tabular $container */
    private $container;

    /**
     * Builder constructor.
     */
    public function __construct()
    {
        $this->container = new Tabular();
    }

    /**
     * Add metadata to the table.
     *
     * @param MetadataInterface $metadata
     *
     * @return $this
     */
    public function withMetadata(MetadataInterface $metadata): self
    {
        $this->container->setMetadata($metadata);

        return $this;
    }

    /**
     * Add a column to the table.
     *
     * @param string|callable $name
     * @param string|callable|null $display
     * @param iterable|null $attributes
     *
     * @return $this
     */
    public function addColumn($name, $display = null, iterable $attributes = null): self
    {
        if (!is_callable($name)) {
            $name = function (Tabular $table) use ($name, $display, $attributes) {
                $column = new Column($table, $name);
                $column->setDisplay($display);
                $column->setAttr($attributes ?? []);

                return $column;
            };
        }

        $this->container->setColumn(call_user_func($name, $this->container));

        return $this;
    }

    /**
     * Add a sortable column to the table.
     *
     * @param string $name
     * @param string|null $display
     * @param iterable|null $attributes
     * @return $this
     */
    public function addSortableColumn(string $name, string $display = null, iterable $attributes = null): self
    {
        return $this->addColumn(
            function (Tabular $table) use ($name, $display, $attributes) {
                $column = new Column($table, $name);
                $column->setDisplay($display);
                $column->setAttr($attributes ?? []);
                $column->setSortable();

                return $column;
            }
        );
    }

    /**
     * Add a custom column to the table.
     *
     * @param string $display
     * @param \Closure $callback
     * @param iterable|null $attributes
     * @return $this
     */
    public function addCustomColumn(string $display, \Closure $callback, iterable $attributes = null): self
    {
        return $this->addColumn(
            function (Tabular $table) use ($display, $callback, $attributes) {
                $column = new Column($table, $display);
                $column->setAttr($attributes ?? []);
                $column->setContent($callback);

                return $column;
            }
        );
    }

    /**
     * Build the table.
     *
     * @return Tabular
     */
    public function build(): Tabular
    {
        try {
            return $this->container;
        } finally {
            $this->container = new Tabular();
        }
    }
}
