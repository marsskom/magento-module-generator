<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Validator;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Exception\Validator\ValidateException;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Helper\Builder\ModuleBuilder;
use function sprintf;

class ModuleValidator
{
    /**
     * Invoke method.
     *
     * @param InputInterface $i
     *
     * @return void
     *
     * @throws ValidateException
     * @throws InputNotExistsException
     */
    public function __invoke(InputInterface $i)
    {
        if (!$i->has(InputParameter::MODULE)) {
            throw new ValidateException("Module name is required");
        }

        $moduleName = $i->get(InputParameter::MODULE);
        try {
            $module = (new ModuleBuilder())->fromMagentoModuleName($moduleName);
        } catch (LocalizedException $exception) {
            throw new ValidateException(sprintf("Module name '%s' is invalid", $moduleName));
        }

        if (empty($module->getVendor()) || empty($module->getName())) {
            throw new ValidateException(sprintf("Module name '%s' is invalid", $moduleName));
        }
    }
}
