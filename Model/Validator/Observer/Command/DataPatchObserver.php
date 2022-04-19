<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Observer\Command;

use Marsskom\Generator\Console\Command\Patch\DataPatchCommand;
use Marsskom\Generator\Model\Validator\Console\ModuleValidatorFactory;
use Marsskom\Generator\Model\Validator\Console\NameValidatorFactory;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;

class DataPatchObserver extends ValidatorObserver
{
    /**
     * @inheritdoc
     *
     * @param ModuleValidatorFactory $moduleFactory
     * @param NameValidator          $nameFactory
     */
    public function __construct(
        ValidatorResultBuilder $resultBuilder,
        ModuleValidatorFactory $moduleFactory,
        NameValidatorFactory $nameFactory
    ) {
        parent::__construct($resultBuilder);

        $this->attach(DataPatchCommand::EVENT_NAME, $moduleFactory->create());
        $this->attach(DataPatchCommand::EVENT_NAME, $nameFactory->create());
    }
}
