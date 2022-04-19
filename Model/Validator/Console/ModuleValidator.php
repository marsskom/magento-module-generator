<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Console;

use Marsskom\Generator\Api\Data\Validator\ValidatorInterface;
use Marsskom\Generator\Exception\ValidateException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use Marsskom\Generator\Model\Validator\Validator;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;

class ModuleValidator extends Validator
{
    private ModuleBuilder $moduleBuilder;

    /**
     * @inheritdoc
     *
     * @param ModuleBuilder $moduleBuilder
     */
    public function __construct(
        ModuleBuilder $moduleBuilder,
        ValidatorResultBuilder $resultBuilder,
        ?ValidatorInterface $next = null
    ) {
        parent::__construct($resultBuilder, $next);

        $this->moduleBuilder = $moduleBuilder;
    }

    /**
     * @inheritdoc
     */
    protected function concreteValidate(array $userInput): void
    {
        $moduleName = $userInput[InputParameter::MODULE] ?? null;

        if (null === $moduleName) {
            throw new ValidateException(__("Module name is required"));
        }

        $module = $this->moduleBuilder->fromMagentoModuleName($moduleName);

        if (empty($module->getVendor()) || empty($module->getName())) {
            throw new ValidateException(__("Module name '%1' is invalid", $moduleName));
        }
    }
}
