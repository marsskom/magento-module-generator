<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

interface ArrayInterface
{
    /**
     * Returns class as array.
     *
     * @return array
     */
    public function toArray(): array;
}
