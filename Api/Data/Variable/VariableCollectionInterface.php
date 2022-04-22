<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Variable;

interface VariableCollectionInterface
{
    /**
     * Returns list of variables.
     *
     * @return VariableInterface[]
     */
    public function variables(): array;
}
