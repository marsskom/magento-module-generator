<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Api;

use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;

interface WriterInterface
{
    /**
     * Returns directory.
     *
     * @return WriteInterface
     *
     * @throws FileSystemException
     */
    public function directory(): WriteInterface;

    /**
     * Return path info.
     *
     * @param string $path
     *
     * @return array
     */
    public function pathInfo(string $path): array;

    /**
     * Verifies that writer can handle current file.
     *
     * @param string $fileName
     *
     * @return bool
     */
    public function validate(string $fileName): bool;

    /**
     * Writes file.
     *
     * @param ContextInterface $context
     *
     * @return void
     */
    public function write(ContextInterface $context): void;

    /**
     * Appends to file.
     *
     * @param ContextInterface $context
     *
     * @return void
     */
    public function append(ContextInterface $context): void;

    /**
     * Skips file.
     *
     * @param ContextInterface $context
     *
     * @return void
     */
    public function skip(ContextInterface $context): void;
}
