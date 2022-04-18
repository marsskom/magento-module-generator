<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Helper;

use Magento\Framework\Exception\FileSystemException;

interface PathInterface
{
    /**
     * Returns path to module.
     *
     * @param string $moduleName
     *
     * @return string
     *
     * @throws FileSystemException
     */
    public function getModulePath(string $moduleName): string;

    /**
     * Returns path to file.
     *
     * @param string $moduleName
     * @param string $pathToFile
     *
     * @return string
     *
     * @throws FileSystemException
     */
    public function getPathToFile(string $moduleName, string $pathToFile): string;
}
