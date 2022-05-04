<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Callables;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Helper\Builder\ModuleBuilder;
use function strrpos;
use function substr;

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
     * @throws VariableNotExistsException
     */
    public function __invoke($c, $i): ContextInterface
    {
        $moduleName = $i->get(InputParameter::MODULE);
        $path = $i->has(InputParameter::PATH) ? $i->get(InputParameter::PATH) : '';

        if (empty($path) && $c->has(ContextVariable::FILENAME_VALUE)) {
            $fileName = $c->get(ContextVariable::FILENAME_VALUE);
            $pos = strrpos($fileName, '/');
            $path = false === $pos ? $fileName : substr($fileName, 0, $pos);
        }

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
