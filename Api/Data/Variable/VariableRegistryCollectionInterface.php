<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Variable;

use Marsskom\Generator\Model\Variable\VariableRegistry;

interface VariableRegistryCollectionInterface
{
    /**
     * Returns list of registries.
     *
     * @return VariableRegistry[]
     */
    public function registries(): array;
}
