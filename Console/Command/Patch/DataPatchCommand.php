<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Patch;

use Marsskom\Generator\Console\Command\GeneratorCommand;
use Marsskom\Generator\Model\Manager\Patch\DataPatchManager;
use Marsskom\Generator\Model\Scope\ScopeBuilder;

class DataPatchCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_data-patch-command';

    /**
     * @inheritdoc
     *
     * @param DataPatchManager $dataPatchManager
     *
     * phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod
     */
    public function __construct(
        DataPatchManager $dataPatchManager,
        ScopeBuilder $scopeBuilder,
        string $name = null
    ) {
        parent::__construct($dataPatchManager, $scopeBuilder, $name);
    }

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
