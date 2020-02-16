<?php

namespace DMT\Twig\Tabular;

use Twig\Error\RuntimeError;

/**
 * Interface MetadataInterface
 *
 * @package DMT\Twig\Tabular
 * @author Bas de Mes <bas@dmt-software.nl>
 */
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

    /**
     * Get the url for paging.
     *
     * @param int $page The page number.
     *
     * @return string
     */
    public function getPagingUrl(int $page): string;
}
