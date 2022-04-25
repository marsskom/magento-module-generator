<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation\Writer;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use function implode;
use const DIRECTORY_SEPARATOR;

class ContextWriter extends AbstractSequence
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
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $directory = $this->filesystem->getDirectoryWrite(DirectoryList::APP);

        $fileName = implode(
            DIRECTORY_SEPARATOR,
            [
                $scope->context()->getPath(),
                $scope->context()->getFileName(),
            ]
        );
        $isFileExists = $directory->isFile($fileName);

        if ($isFileExists
            && !$scope->interrupt()->ask(
                __("File '%1' already exists, it will be lost. Overwrite? [Y/n]: ", $fileName)
            )) {
            $scope->interrupt()->info(
                __("File '%1' was skipped", $fileName)
            );

            return $scope;
        }

        $stream = $directory->openFile($fileName);
        $stream->lock();
        $stream->write((string) $scope->context()->getTemplate());
        $stream->unlock();
        $stream->close();

        if ($isFileExists) {
            $scope->interrupt()->info(
                __("File '%1' was overwrote", $fileName)
            );
        }

        return $scope;
    }
}
