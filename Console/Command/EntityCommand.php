<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

class EntityCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_entity-command';
    
    public const COMMAND_HAS_INTERFACE_PARAMETER = 'i';
    
    public const COMMAND_IS_DATA_OBJECT_PARAMETER = 'do';

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:entity');
        $this->setDescription("Generates entity.");

        parent::configure();
    }

    /**
     * @inheritdoc
     */
    protected function getEventName(): string
    {
        return self::EVENT_NAME;
    }
}
