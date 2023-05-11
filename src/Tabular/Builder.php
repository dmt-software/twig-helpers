<?php

namespace DMT\Twig\Tabular;

class Builder
{
    private Tabular $tabular;

    public function __construct()
    {
        $this->tabular = new Tabular();
    }

    /**
     * Add metadata to the table.
     */
    public function withMetadata(MetadataInterface $metadata): self
    {
        $this->tabular->setMetadata($metadata);

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

        $this->tabular->setColumn(call_user_func($name, $this->tabular));

        return $this;
    }

    /**
     * Add a sortable column to the table.
     *
     * @param string $name
     * @param string|null $display
     * @param iterable|null $attributes
     *
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
     *
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

    public function build(): Tabular
    {
        try {
            return $this->tabular;
        } finally {
            $this->tabular = new Tabular();
        }
    }
}
