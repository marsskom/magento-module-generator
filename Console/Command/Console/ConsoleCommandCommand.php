<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Console;

use Marsskom\Generator\Console\Command\GeneratorCommand;
use Marsskom\Generator\Model\Enum\InputParameter;
use Symfony\Component\Console\Input\InputOption;

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

    /**
     * @inheritdoc
     */
    protected function getDefaultPathParam(): string
    {
        return 'Console/Command';
    }

    /**
     * @inheritdoc
     */
    protected function optionsList(): array
    {
        return [
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
            new InputOption(
                self::COMMAND_NAME_PARAMETER,
                null,
                InputOption::VALUE_OPTIONAL,
                'Command name'
            ),
            new InputOption(
                self::COMMAND_DESC_PARAMETER,
                null,
                InputOption::VALUE_OPTIONAL,
                'Command description'
            ),
        ];
    }
}
