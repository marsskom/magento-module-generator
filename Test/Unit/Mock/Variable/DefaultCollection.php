<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableCollectionInterface;
use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Model\Variable\Variable;

class DefaultCollection implements VariableCollectionInterface
{
    /**
     * @inheritdoc
     */
    public function variables(): array
    {
        return [
            new Variable(
                'simple_generator',
                VariableInterface::IS_REWRITABLE
            ),
        ];
    }
}
