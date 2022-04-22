<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableRegistryCollectionInterface;
use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Model\Variable\VariableRegistry;

class DefaultRegistryCollection implements VariableRegistryCollectionInterface
{
    /**
     * @inheritdoc
     */
    public function registries(): array
    {
        return [
            new VariableRegistry(
                'simple_generator',
                VariableInterface::IS_REWRITABLE
            ),
        ];
    }
}
