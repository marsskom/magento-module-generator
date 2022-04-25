<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Api\Data\Variable\VariableRegistryCollectionInterface;
use Marsskom\Generator\Model\Variable\VariableRegistry;
use function implode;

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
            new VariableRegistry(
                'str_as_array',
                VariableInterface::DEFAULT,
                static function ($values): string {
                    return $values ? implode('', $values) : '';
                }
            ),
            new VariableRegistry(
                'array',
                VariableInterface::DEFAULT,
            ),
            new VariableRegistry(
                'simple',
                VariableInterface::IS_SIMPLE,
            ),
        ];
    }
}
