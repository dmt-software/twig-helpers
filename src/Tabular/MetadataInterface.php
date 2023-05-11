<?php

namespace DMT\Twig\Tabular;

interface MetadataInterface
{
    /**
     * Get the url for sorting on a column.
     *
     * @param Column $column The column to sort.
     *
     * @return string
     */
    public function getSortingUrl(Column $column): string;
}
