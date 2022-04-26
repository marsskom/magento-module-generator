<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable\RegistryCollection;

use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Api\Data\Variable\VariableRegistryCollectionInterface;
use Marsskom\Generator\Model\Variable\VariableRegistry;

class CronRegistryCollection implements VariableRegistryCollectionInterface
{
    /**
     * @inheritdoc
     */
    public function registries(): array
    {
        return [
            new VariableRegistry(
                'cronjob_group',
                VariableInterface::IS_SIMPLE
            ),
            new VariableRegistry(
                'cronjob_name',
                VariableInterface::IS_SIMPLE
            ),
            new VariableRegistry(
                'cronjob_class',
                VariableInterface::IS_SIMPLE
            ),
            new VariableRegistry(
                'cronjob_schedule',
                VariableInterface::IS_SIMPLE
            ),
        ];
    }
}
