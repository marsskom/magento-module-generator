<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context\Input;

interface ClassInterface
{
    /**
     * Returns class name.
     *
     * @return string
     */
    public function getClassName(): string;

    /**
     * Returns true if extends exists.
     *
     * @return bool
     */
    public function hasExtends(): bool;

    /**
     * Returns parent class.
     *
     * @return string
     */
    public function getExtends(): string;

    /**
     * Returns true if implements exists.
     *
     * @return bool
     */
    public function hasImplements(): bool;

    /**
     * Returns interfaces that need to be implemented.
     *
     * @return string[]
     */
    public function getImplements(): array;

    /**
     * Returns true if comments exists.
     *
     * @return bool
     */
    public function hasComments(): bool;

    /**
     * Returns comment strings.
     *
     * @return string[]
     */
    public function getComments(): array;
}
