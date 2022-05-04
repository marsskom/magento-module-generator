<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Helper\Callables;

class NameHelper
{
    /**
     * Converts id name ("some-name") into class name ("SomeName").
     *
     * @param string $name
     *
     * @return string
     */
    public function id2Class(string $name): string
    {
        if (empty($name)) {
            return (string) $name;
        }

        return str_replace(
            ' ',
            '',
            ucwords(
                str_replace(['-', '_'], ' ', $name)
            )
        );
    }
}
