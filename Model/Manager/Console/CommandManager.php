<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Manager\Console;

use Marsskom\Generator\Api\Data\ComponentManagerInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Marsskom\Generator\Console\Command\Console\ConsoleCommandCommand;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Stub\Console\CommandSequenceFactory;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\Console\NameValidator;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class CommandManager implements ComponentManagerInterface
{
    private GlobalFactory $globalFactory;

    private CommandSequenceFactory $sequenceFactory;

    /**
     * Manager constructor.
     *
     * @param GlobalFactory          $globalFactory
     * @param CommandSequenceFactory $sequenceFactory
     */
    public function __construct(
        GlobalFactory $globalFactory,
        CommandSequenceFactory $sequenceFactory
    ) {
        $this->globalFactory = $globalFactory;
        $this->sequenceFactory = $sequenceFactory;
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
                'File location',
                'Console/Command'
            ),
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
            new InputOption(
                ConsoleCommandCommand::COMMAND_NAME_PARAMETER,
                null,
                InputOption::VALUE_OPTIONAL,
                'Command name'
            ),
            new InputOption(
                ConsoleCommandCommand::COMMAND_DESC_PARAMETER,
                null,
                InputOption::VALUE_OPTIONAL,
                'Command description'
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function validationObserver(): ValidationObserverInterface
    {
        return new ValidatorObserver(
            ConsoleCommandCommand::EVENT_NAME,
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
        return $this->sequenceFactory->create();
    }
}
