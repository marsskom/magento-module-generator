<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable\Closures;

use function implode;

/**
 * phpcs:disable Magento2.Functions.StaticFunction
 */
class DefaultClosures
{
    /**
     * Returns values connected by new line.
     *
     * @param null|array $values
     *
     * @return string
     */
    public static function implodeByNewLine(?array $values): string
    {
        return $values ? implode("\n", $values) : '';
    }

    /**
     * Returns extends string.
     *
     * @param null|array $values
     *
     * @return string
     */
    public static function implodeExtends(?array $values): string
    {
        return $values ? ' extends ' . implode(', ', $values) : '';
    }

    /**
     * Returns implements string.
     *
     * @param null|array $values
     *
     * @return string
     */
    public static function implodeImplements(?array $values): string
    {
        return $values ? ' implements ' . implode(', ', $values) : '';
    }
}
