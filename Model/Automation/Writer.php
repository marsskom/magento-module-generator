<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Automation;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use function implode;

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

        $stream = $directory->openFile(
            implode(
                DIRECTORY_SEPARATOR,
                [
                    $context->output()->getPath(),
                    $context->output()->getFileName(),
                ]
            )
        );
        $stream->lock();
        $stream->write((string) $context->output()->get());
        $stream->unlock();
        $stream->close();

        return $context;
    }
}
