<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator;

use Marsskom\Generator\Api\Data\Validator\ValidateResultInterface;

class ValidatorResultBuilder
{
    /**
     * Creates validator result.
     *
     * @param bool   $status
     * @param string $message
     * @param array  $trace
     *
     * @return ValidateResultInterface
     */
    public function create(bool $status, string $message = '', array $trace = []): ValidateResultInterface
    {
        return new ValidateResult($status, $message, $trace);
    }

    /**
     * Creates passed validation result.
     *
     * @return ValidateResultInterface
     */
    public function createPassed(): ValidateResultInterface
    {
        return $this->create(true);
    }

    /**
     * Returns failed validation result.
     *
     * @param string $message
     * @param array  $trace
     *
     * @return ValidateResultInterface
     */
    public function createFailed(string $message = '', array $trace = []): ValidateResultInterface
    {
        return $this->create(false, $message, $trace);
    }
}
