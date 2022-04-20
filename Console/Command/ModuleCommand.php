<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

class ModuleCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_module-command';

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:module');
        $this->setDescription("Generates module.");

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
