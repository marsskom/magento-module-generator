<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Manager\Crontab;

use Marsskom\Generator\Api\Data\ComponentManagerInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Marsskom\Generator\Console\Command\Crontab\CronCommand;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Context\ContextUsageGenerator;
use Marsskom\Generator\Model\Sequence\Automation\Writer\ScopeWriter;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\ClassNameFromPathGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\StubGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Crontab\CronContextRegister;
use Marsskom\Generator\Model\Sequence\Stub\Crontab\Cronjob\CronjobSequence;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\Console\NameValidator;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class CronManager implements ComponentManagerInterface
{
    private GlobalFactory $globalFactory;

    /**
     * Cron manager.
     *
     * @param GlobalFactory $globalFactory
     */
    public function __construct(
        GlobalFactory $globalFactory
    ) {
        $this->globalFactory = $globalFactory;
    }

    /**
     * @inheritdoc
     */
    public function inputDefinition(): InputDefinition
    {
        return new InputDefinition([
            new InputOption(
                InputParameter::MODULE,
                null,
                InputOption::VALUE_REQUIRED,
                'Module name (Vendor_Module)'
            ),
            new InputOption(
                InputParameter::PATH,
                null,
                InputOption::VALUE_OPTIONAL,
                'Cron class location',
                'Cron'
            ),
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Cronjob name (example - "export_products")'
            ),
            new InputOption(
                CronCommand::COMMAND_GROUP,
                null,
                InputOption::VALUE_OPTIONAL,
                'Cronjob group (example - "export")',
                'default'
            ),
            new InputOption(
                CronCommand::COMMAND_SCHEDULE,
                null,
                InputOption::VALUE_OPTIONAL,
                'Cronjob schedule (example - "*/5 * * * *")',
                '*/5 * * * *'
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function validationObserver(): ValidationObserverInterface
    {
        return new ValidatorObserver(
            CronCommand::EVENT_NAME,
            [
                $this->globalFactory->create(ModuleValidator::class),
                $this->globalFactory->create(NameValidator::class),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function sequence(): SequenceInterface
    {
        return new Sequence([
            $this->globalFactory->create(CronContextRegister::class),
            $this->globalFactory->create(ContextUsageGenerator::class, [
                'contextAlias' => ScopeInterface::DEFAULT_CONTEXT,
            ]),
            $this->globalFactory->create(NamespaceGenerator::class),
            $this->globalFactory->create(ClassNameFromPathGenerator::class),
            $this->globalFactory->create(StubGenerator::class, [
                'stubName' => 'cron/class.stub',
            ]),
            $this->globalFactory->create(CronjobSequence::class),
            $this->globalFactory->create(ScopeWriter::class),
        ]);
    }
}
