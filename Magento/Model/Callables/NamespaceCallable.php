<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Callables;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Helper\Builder\ModuleBuilder;

class NamespaceCallable
{
    /**
     * Invoke method.
     *
     * @param ContextInterface $c
     * @param InputInterface   $i
     *
     * @return ContextInterface
     *
     * @throws LocalizedException
     * @throws InputNotExistsException
     */
    public function __invoke($c, $i): ContextInterface
    {
        $moduleName = $i->get(InputParameter::MODULE);
        $path = $i->has(InputParameter::PATH) ? $i->get(InputParameter::PATH) : '';

        $namespace = $this->getNamespace($moduleName, $path);

        return $c->set(
            TemplateVariable::FILE_NAMESPACE,
            str_replace('\\\\', '\\', $namespace)
        );
    }

    /**
     * Returns namespace.
     *
     * @param string $moduleName
     * @param string $path
     *
     * @return string
     *
     * @throws LocalizedException
     */
    protected function getNamespace(string $moduleName, string $path): string
    {
        $module = (new ModuleBuilder())->fromMagentoModuleName($moduleName);

        return implode(
            '\\',
            [
                $module->getVendor(),
                $module->getName(),
                str_replace('/', '\\', $path),
            ]
        );
    }
}
