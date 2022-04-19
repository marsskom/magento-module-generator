<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Observer;

use Marsskom\Generator\Console\Command\ModuleCommand;
use Marsskom\Generator\Model\Validator\Console\ModuleValidatorFactory;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;

class ModuleObserver extends ValidatorObserver
{
    /**
     * @inheritdoc
     *
     * @param ModuleValidator $moduleFactory
     */
    public function __construct(
        ValidatorResultBuilder $resultBuilder,
        ModuleValidatorFactory $moduleFactory
    ) {
        parent::__construct($resultBuilder);

        $this->attach(ModuleCommand::EVENT_NAME, $moduleFactory->create());
    }
}
