<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command\Crontab;

use Marsskom\Generator\Console\Command\GeneratorCommand;
use Marsskom\Generator\Model\Manager\Crontab\CronManager;
use Marsskom\Generator\Model\Scope\ScopeBuilder;

class CronCommand extends GeneratorCommand
{
    public const EVENT_NAME = 'console_command_cron-command';

    public const COMMAND_GROUP = 'group';

    public const COMMAND_SCHEDULE = 'schedule';

    /**
     * @inheritdoc
     *
     * @param CronManager $cronManager
     *
     * phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod
     */
    public function __construct(
        CronManager $cronManager,
        ScopeBuilder $scopeBuilder,
        string $name = null
    ) {
        parent::__construct($cronManager, $scopeBuilder, $name);
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:cron');
        $this->setDescription("Generates cronjob.");

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
