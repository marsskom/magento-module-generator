<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Observer\Console;

use Marsskom\Generator\Console\Command\Console\ConsoleCommandCommand;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\Console\NameValidator;
use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;

class CommandObserver extends ValidatorObserver
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

        $this->attach(ConsoleCommandCommand::EVENT_NAME, $moduleValidator);
        $this->attach(ConsoleCommandCommand::EVENT_NAME, $nameValidator);
    }
}
