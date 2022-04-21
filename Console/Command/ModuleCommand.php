<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

use Marsskom\Generator\Model\Context\ContextBuilder;
use Marsskom\Generator\Model\Manager\ModuleManager;

class ModuleCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_module-command';

    /**
     * @inheritdoc
     *
     * @param ModuleManager $moduleManager
     */
    public function __construct(
        ModuleManager $moduleManager,
        ContextBuilder $contextBuilder,
        string $name = null
    ) {
        parent::__construct($moduleManager, $contextBuilder, $name);
    }

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
