<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Manager\Patch;

use Marsskom\Generator\Api\Data\ComponentManagerInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Marsskom\Generator\Console\Command\Patch\DataPatchCommand;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ClassNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Patch\DataPatchContextRegister;
use Marsskom\Generator\Model\Sequence\Stub\Patch\DataPatchGenerator;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\Console\NameValidator;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DataPatchManager implements ComponentManagerInterface
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
            new InputOption(
                InputParameter::PATH,
                null,
                InputOption::VALUE_OPTIONAL,
                'File location',
                'Setup/Patch/Data'
            ),
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function validationObserver(): ValidationObserverInterface
    {
        return new ValidatorObserver(
            DataPatchCommand::EVENT_NAME,
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
            $this->globalFactory->create(DataPatchContextRegister::class),
            $this->globalFactory->create(NamespaceGenerator::class),
            $this->globalFactory->create(ClassNameGenerator::class),
            $this->globalFactory->create(DataPatchGenerator::class),
            $this->globalFactory->create(Writer::class),
        ]);
    }
}
