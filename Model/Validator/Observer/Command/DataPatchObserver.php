<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Observer\Command;

use Marsskom\Generator\Console\Command\Patch\DataPatchCommand;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\Console\NameValidator;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;

class DataPatchObserver extends ValidatorObserver
{
    /**
     * @inheritdoc
     *
     * @param ModuleValidator $moduleValidator
     * @param NameValidator   $nameValidator
     */
    public function __construct(
        ValidatorResultBuilder $resultBuilder,
        ModuleValidator $moduleValidator,
        NameValidator $nameValidator
    ) {
        parent::__construct($resultBuilder);

        $this->attach(DataPatchCommand::EVENT_NAME, $moduleValidator);
        $this->attach(DataPatchCommand::EVENT_NAME, $nameValidator);
    }
}
