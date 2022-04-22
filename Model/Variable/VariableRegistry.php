<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableInterface;

class VariableRegistry
{
    private string $name;

    private int $options;

    /**
     * Variable registry constructor.
     *
     * @param string $name
     * @param int    $options
     */
    public function __construct(
        string $name,
        int $options = VariableInterface::DEFAULT
    ) {
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * Returns variable name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns variable options.
     *
     * @return int
     */
    public function getOptions(): int
    {
        return $this->options;
    }
}
