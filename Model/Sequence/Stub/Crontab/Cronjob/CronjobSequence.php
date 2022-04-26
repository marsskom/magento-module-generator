<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Crontab\Cronjob;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Console\Command\Crontab\CronCommand;
use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Context\ContextUsageGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ConditionGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\StubGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Crontab\CronDefaultSequence;
use function array_merge;

class CronjobSequence extends Sequence
{
    /**
     * @inheritdoc
     *
     * @param GlobalFactory $globalFactory
     */
    public function __construct(
        GlobalFactory $globalFactory,
        array $sequences = []
    ) {
        parent::__construct(array_merge([
            $globalFactory->create(CronDefaultSequence::class),
            $globalFactory->create(ContextUsageGenerator::class, [
                'contextAlias' => 'crontab',
            ]),
            $globalFactory->create(StubGenerator::class, [
                'stubName' => 'cron/crontab.stub',
            ]),
            $globalFactory->create(ConditionGenerator::class, [
                'callback'  => static function (ScopeInterface $scope): bool {
                    return 'default' !== $scope->input()->get(CronCommand::COMMAND_GROUP);
                },
                'sequences' => [
                    $globalFactory->create(ContextUsageGenerator::class, [
                        'contextAlias' => 'group',
                    ]),
                    $globalFactory->create(StubGenerator::class, [
                        'stubName' => 'cron/cron_groups.stub',
                    ]),
                ],
            ]),
        ], $sequences));
    }
}
