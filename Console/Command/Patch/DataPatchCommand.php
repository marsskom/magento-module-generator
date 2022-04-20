<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Patch;

use Marsskom\Generator\Console\Command\GeneratorCommand;

class DataPatchCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_data-patch-command';

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:patch:data');
        $this->setDescription("Generates data patch class.");

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
