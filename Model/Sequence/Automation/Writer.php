<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use function implode;
use const DIRECTORY_SEPARATOR;

class Writer extends AbstractSequence
{
    private Filesystem $filesystem;

    /**
     * @inheritdoc
     *
     * @param Filesystem $filesystem
     */
    public function __construct(
        Filesystem $filesystem,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->filesystem = $filesystem;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $directory = $this->filesystem->getDirectoryWrite(DirectoryList::APP);

        $fileName = implode(
            DIRECTORY_SEPARATOR,
            [
                $context->getPath(),
                $context->getFileName(),
            ]
        );
        $isFileExists = $directory->isFile($fileName);

        if ($isFileExists
            && !$context->interrupt()->ask(
                __("File '%1' already exists, it will be lost. Overwrite? [Y/n]: ", $fileName)
            )) {
            $context->interrupt()->info(
                __("File '%1' was skipped", $fileName)
            );
            
            return $context;
        }

        $stream = $directory->openFile($fileName);
        $stream->lock();
        $stream->write((string) $context->getTemplate());
        $stream->unlock();
        $stream->close();
        
        if ($isFileExists) {
            $context->interrupt()->info(
                __("File '%1' was overwrote", $fileName)
            );
        }

        return $context;
    }
}
