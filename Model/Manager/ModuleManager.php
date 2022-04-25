<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Manager;

use Marsskom\Generator\Api\Data\ComponentManagerInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Marsskom\Generator\Console\Command\ModuleCommand;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Stub\Module\ModuleContextRegister;
use Marsskom\Generator\Model\Sequence\Stub\Module\ModuleFileSequence;
use Marsskom\Generator\Model\Sequence\Stub\Module\RegistrationSequence;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class ModuleManager implements ComponentManagerInterface
{
    private GlobalFactory $globalFactory;

    /**
     * Manager constructor.
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
        ]);
    }

    /**
     * @inheritdoc
     */
    public function validationObserver(): ValidationObserverInterface
    {
        return new ValidatorObserver(
            ModuleCommand::EVENT_NAME,
            [
                $this->globalFactory->create(ModuleValidator::class),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function sequence(): SequenceInterface
    {
        return new Sequence([
            $this->globalFactory->create(ModuleContextRegister::class),
            $this->globalFactory->create(RegistrationSequence::class),
            $this->globalFactory->create(ModuleFileSequence::class),
        ]);
    }
}
