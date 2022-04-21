<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Patch;

use Marsskom\Generator\Console\Command\GeneratorCommand;
use Marsskom\Generator\Model\Context\ContextBuilder;
use Marsskom\Generator\Model\Manager\Patch\DataPatchManager;

class DataPatchCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_data-patch-command';

    /**
     * @inheritdoc
     *
     * @param DataPatchManager $dataPatchManager
     */
    public function __construct(
        DataPatchManager $dataPatchManager,
        ContextBuilder $contextBuilder,
        string $name = null
    ) {
        parent::__construct($dataPatchManager, $contextBuilder, $name);
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
