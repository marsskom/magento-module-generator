<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Infrastructure\Api\PathInterface;
use Marsskom\Generator\Magento\Model\Helper\Module;
use function implode;
use function ltrim;
use const DIRECTORY_SEPARATOR;

class Path implements PathInterface
{
    private const CODE_DIR_NAME = 'code';

    private DirectoryList $directoryList;

    /**
     * Path constructor.
     *
     * @param DirectoryList $directoryList
     */
    public function __construct(
        DirectoryList $directoryList
    ) {
        $this->directoryList = $directoryList;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function module(Module $module): string
    {
        $directoryPath = $this->directoryList->getPath(DirectoryList::APP);

        return implode(
            DIRECTORY_SEPARATOR,
            [
                $directoryPath,
                self::CODE_DIR_NAME,
                $module->getVendor(),
                $module->getName(),
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function path(Module $module, string $path): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [
                $this->module($module),
                ltrim($path, DIRECTORY_SEPARATOR),
            ]
        );
    }
}
