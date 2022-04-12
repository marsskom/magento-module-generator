<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context\Input;

use Marsskom\Generator\Model\Helper\UseModel;

interface FileInterface
{
    /**
     * Returns file name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns file extension.
     *
     * @return string
     */
    public function getExtension(): string;

    /**
     * Returns file full name.
     *
     * @return string
     */
    public function getFullName(): string;

    /**
     * Returns path to file.
     *
     * @return string
     */
    public function getPathToFile(): string;

    /**
     * Returns namespace.
     *
     * @return string
     */
    public function getNamespace(): string;

    /**
     * Returns true is uses exist.
     *
     * @return bool
     */
    public function hasUses(): bool;

    /**
     * Return uses array.
     *
     * @return UseModel[]
     */
    public function getUses(): array;
}
