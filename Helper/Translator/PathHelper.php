<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Helper\Translator;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Model\Helper\ModuleBuilder;

class PathHelper
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
        $module = $this->moduleBuilder->fromCliString($moduleName);

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
     * @param string $fileName
     *
     * @return string
     * @throws FileSystemException
     */
    public function getPathToFile(string $moduleName, string $fileName): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [

                $this->getModulePath($moduleName),
                $fileName,
            ]
        );
    }
}
