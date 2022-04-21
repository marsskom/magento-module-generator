<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

use Marsskom\Generator\Model\Context\ContextBuilder;
use Marsskom\Generator\Model\Manager\EntityManager;

class EntityCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_entity-command';

    public const COMMAND_HAS_INTERFACE_PARAMETER = 'i';

    public const COMMAND_IS_DATA_OBJECT_PARAMETER = 'do';

    /**
     * @inheritdoc
     *
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager,
        ContextBuilder $contextBuilder,
        string $name = null
    ) {
        parent::__construct($entityManager, $contextBuilder, $name);
    }

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
