<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Validator;

interface ValidateResultInterface
{
    /**
     * Returns validation status.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Returns error message.
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Returns trace data.
     *
     * @return array
     */
    public function getTrace(): array;
}
