<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Helper\Translator;

use Marsskom\Generator\Model\Helper\ModuleBuilder;
use function implode;
use function str_replace;

class NamespaceHelper
{
    private ModuleBuilder $moduleBuilder;

    /**
     * Namespace helper constructor.
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
        $module = $this->moduleBuilder->fromCliString($moduleName);

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
