<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

use Marsskom\Generator\Model\Manager\ModuleManager;
use Marsskom\Generator\Model\Scope\ScopeBuilder;

class ModuleCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_module-command';

    /**
     * @inheritdoc
     *
     * @param ModuleManager $moduleManager
     *
     * phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod
     */
    public function __construct(
        ModuleManager $moduleManager,
        ScopeBuilder $scopeBuilder,
        string $name = null
    ) {
        parent::__construct($moduleManager, $scopeBuilder, $name);
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
