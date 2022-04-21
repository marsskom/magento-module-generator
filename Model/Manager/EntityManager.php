<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Manager;

use Marsskom\Generator\Api\Data\ComponentManagerInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Marsskom\Generator\Console\Command\EntityCommand;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\InputOption\Entity\PropertiesOption;
use Marsskom\Generator\Model\Sequence\Stub\Entity\EntitySequenceFactory;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\Console\NameValidator;
use Marsskom\Generator\Model\Validator\Entity\PropertiesValidator;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class EntityManager implements ComponentManagerInterface
{
    private GlobalFactory $globalFactory;

    private EntitySequenceFactory $sequenceFactory;

    /**
     * Manager constructor.
     *
     * @param GlobalFactory         $globalFactory
     * @param EntitySequenceFactory $sequenceFactory
     */
    public function __construct(
        GlobalFactory $globalFactory,
        EntitySequenceFactory $sequenceFactory
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
                'Model'
            ),
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
            PropertiesOption::create(),
            new InputOption(
                EntityCommand::COMMAND_HAS_INTERFACE_PARAMETER,
                null,
                InputOption::VALUE_OPTIONAL,
                'Indicates whether to create an interface for class',
                false
            ),
            new InputOption(
                EntityCommand::COMMAND_IS_DATA_OBJECT_PARAMETER,
                null,
                InputOption::VALUE_OPTIONAL,
                'Indicates whether tha class extends DataObject',
                false
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function validationObserver(): ValidationObserverInterface
    {
        return new ValidatorObserver(
            EntityCommand::EVENT_NAME,
            [
                $this->globalFactory->create(ModuleValidator::class),
                $this->globalFactory->create(NameValidator::class),
                $this->globalFactory->create(PropertiesValidator::class),
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
