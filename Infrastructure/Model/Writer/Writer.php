<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\Writer;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\Filesystem\Io\File;
use Marsskom\Generator\Infrastructure\Api\WriterInterface;

abstract class Writer implements WriterInterface
{
    private Filesystem $filesystem;

    private File $file;

    /**
     * Writer constructor.
     *
     * @param Filesystem $filesystem
     * @param File       $file
     */
    public function __construct(
        Filesystem $filesystem,
        File $file
    ) {
        $this->filesystem = $filesystem;
        $this->file = $file;
    }

    /**
     * @inheritdoc
     */
    public function directory(): WriteInterface
    {
        return $this->filesystem->getDirectoryWrite(DirectoryList::APP);
    }

    /**
     * @inheritdoc
     */
    public function pathInfo(string $path): array
    {
        return $this->file->getPathInfo($path);
    }
}
