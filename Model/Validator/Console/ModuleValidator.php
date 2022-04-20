<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Console;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Api\Data\Validator\ValidatorInterface;
use Marsskom\Generator\Exception\ValidateException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use Marsskom\Generator\Model\Validator\Validator;

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
        ?ValidatorInterface $next = null
    ) {
        parent::__construct($next);

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

        try {
            $module = $this->moduleBuilder->fromMagentoModuleName($moduleName);
        } catch (LocalizedException $exception) {
            throw new ValidateException(__("Module name '%1' is invalid", $moduleName));
        }

        if (empty($module->getVendor()) || empty($module->getName())) {
            throw new ValidateException(__("Module name '%1' is invalid", $moduleName));
        }
    }
}
