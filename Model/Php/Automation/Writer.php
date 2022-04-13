<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Automation;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Model\Php\Foundation\AbstractSequence;
use const DIRECTORY_SEPARATOR;

class Writer extends AbstractSequence
{
    private Filesystem $filesystem;

    /**
     * Writer constructor.
     *
     * @param Filesystem               $filesystem
     * @param array<SequenceInterface> $sequences
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
            $context->input()->path()->toFile() . DIRECTORY_SEPARATOR . $context->input()->file()->getFullName()
        );
        $stream->lock();
        $stream->write($context->output()->asString());
        $stream->unlock();
        $stream->close();

        return $context;
    }
}
