<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Helper;

use Marsskom\Generator\Api\Data\Helper\PathInterface;
use Marsskom\Generator\Model\Helper\Module;
use function implode;
use function sys_get_temp_dir;
use const DIRECTORY_SEPARATOR;

class Path implements PathInterface
{
    /**
     * @inheritdoc
     */
    public function getModulePath(string $moduleName): string
    {
        $module = $this->getModule($moduleName);

        return implode(
            DIRECTORY_SEPARATOR,
            [
                sys_get_temp_dir(),
                $module->getVendor(),
                $module->getName(),
            ]
        );
    }

    /**
     * Returns module class.
     *
     * @param string $moduleName
     *
     * @return Module
     */
    protected function getModule(string $moduleName): Module
    {
        $chunks = explode('_', $moduleName);

        return new Module($chunks[0], $chunks[1]);
    }

    /**
     * @inheritdoc
     */
    public function getPathToFile(string $moduleName, string $pathToFile): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $this->getModulePath($moduleName),
                ltrim($pathToFile, DIRECTORY_SEPARATOR),
            ]
        );
    }
}
