<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper;

use function implode;

class Separated
{
    /**
     * @var string[]
     */
    private array $collection = [];

    /**
     * Adds chunk into collection.
     *
     * @param string $chunk
     *
     * @return $this
     */
    public function add(string $chunk): self
    {
        $this->collection[] = $chunk;

        return $this;
    }

    /**
     * To string magic method.
     *
     * @return string
     */
    public function __toString(): string
    {
        return implode("\n", $this->collection);
    }
}
