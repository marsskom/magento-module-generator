<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Automation;

use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;

class NamespaceModel
{
    private ModuleBuilder $moduleBuilder;

    /**
     * Namespace model constructor.
     *
     * @param ModuleBuilder $moduleBuilder
     */
    public function __construct(
        ModuleBuilder $moduleBuilder
    ) {
        $this->moduleBuilder = $moduleBuilder;
    }

    /**
     * Returns namespace.
     *
     * @param string $moduleName
     * @param string $path
     *
     * @return string
     */
    public function getNamespace(string $moduleName, string $path = ''): string
    {
        $module = $this->moduleBuilder->fromMagentoModuleName($moduleName);

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
