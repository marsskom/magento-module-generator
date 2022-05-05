<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\Writer;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Infrastructure\Exception\Writer\CannotAppendContentException;
use Marsskom\Generator\Infrastructure\Exception\Writer\FileWasSkippedException;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;

class PhpWriter extends Writer
{
    /**
     * @inheritdoc
     */
    public function validate(string $fileName): bool
    {
        $pathInfo = $this->pathInfo($fileName);

        return 'php' === $pathInfo['extension'];
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     * @throws VariableNotExistsException
     */
    public function write(ContextInterface $context): void
    {
        $stream = $this->directory()->openFile(
            (string) $context->get(ContextVariable::FILENAME_VALUE)
        );
        $stream->lock();
        $stream->write((string) $context->get(ContextVariable::TEMPLATE_VALUE));
        $stream->unlock();
        $stream->close();
    }

    /**
     * @inheritdoc
     *
     * @throws CannotAppendContentException
     */
    public function append(ContextInterface $context): void
    {
        throw new CannotAppendContentException(__("Cannot append content into php file."));
    }

    /**
     * @inheritdoc
     *
     * @throws FileWasSkippedException
     * @throws VariableNotExistsException
     */
    public function skip(ContextInterface $context): void
    {
        $fileName = (string) $context->get(ContextVariable::FILENAME_VALUE);

        throw new FileWasSkippedException(__("File '%1' was skipped.", [$fileName]));
    }
}
