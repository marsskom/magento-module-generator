<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use function ltrim;
use const DIRECTORY_SEPARATOR;

class Path
{
    private DirectoryList $directoryList;

    private ModuleBuilder $moduleBuilder;

    /**
     * Path helper constructor.
     *
     * @param DirectoryList $directoryList
     * @param ModuleBuilder $moduleBuilder
     */
    public function __construct(
        DirectoryList $directoryList,
        ModuleBuilder $moduleBuilder
    ) {
        $this->directoryList = $directoryList;
        $this->moduleBuilder = $moduleBuilder;
    }

    /**
     * Returns path to module.
     *
     * @param string $moduleName
     *
     * @return string
     * @throws FileSystemException
     */
    public function getModulePath(string $moduleName): string
    {
        $module = $this->moduleBuilder->fromMagentoModuleName($moduleName);

        $directoryPath = $this->directoryList->getPath(DirectoryList::APP);

        return implode(
            DIRECTORY_SEPARATOR,
            [
                $directoryPath,
                'code',
                $module->getVendor(),
                $module->getName(),
            ]
        );
    }

    /**
     * Returns path to file.
     *
     * @param string $moduleName
     * @param string $pathToFile
     *
     * @return string
     * @throws FileSystemException
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
