<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Console;

use Marsskom\Generator\Console\Command\GeneratorCommand;

class ConsoleCommandCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console-command_console-command';

    public const COMMAND_NAME_PARAMETER = 'cname';

    public const COMMAND_DESC_PARAMETER = 'cdesc';

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:console:command');
        $this->setDescription("Generates console command class.");

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
