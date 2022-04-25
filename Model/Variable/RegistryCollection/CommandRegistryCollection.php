<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable\RegistryCollection;

use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Api\Data\Variable\VariableRegistryCollectionInterface;
use Marsskom\Generator\Model\Variable\VariableRegistry;

class CommandRegistryCollection implements VariableRegistryCollectionInterface
{
    /**
     * @inheritdoc
     */
    public function registries(): array
    {
        return [
            new VariableRegistry(
                'command_name',
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
            new VariableRegistry(
                'command_description',
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
        ];
    }
}
