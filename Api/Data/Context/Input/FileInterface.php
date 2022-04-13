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
     * Returns namespace.
     *
     * @return string
     */
    public function getNamespace(): string;

    /**
     * Returns true if the uses exist.
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
