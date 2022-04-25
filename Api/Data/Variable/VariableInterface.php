<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Variable;

interface VariableInterface
{
    public const DEFAULT = 1;

    public const IS_SIMPLE = 2;

    public const IS_REWRITABLE = 4;

    /**
     * Returns name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns options.
     *
     * @return int
     */
    public function getOptions(): int;

    /**
     * Returns value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Returns true if variable can only have one value.
     *
     * @return bool
     */
    public function isSimple(): bool;

    /**
     * Returns true if var is rewritable.
     *
     * @return bool
     */
    public function isRewritable(): bool;

    /**
     * Returns string representation closure.
     *
     * @return mixed
     */
    public function getStringRepresentation();

    /**
     * Returns true if string representation closure exists.
     *
     * @return bool
     */
    public function hasStringRepresentation(): bool;
}
