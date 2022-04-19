<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator;

use Marsskom\Generator\Api\Data\Validator\ValidateResultInterface;

class ValidateResult implements ValidateResultInterface
{
    private bool $status;

    private string $message;

    private array $trace;

    /**
     * Validate result constructor.
     *
     * @param bool   $status
     * @param string $message
     * @param array  $trace
     */
    public function __construct(
        bool $status,
        string $message,
        array $trace
    ) {
        $this->status = $status;
        $this->message = $message;
        $this->trace = $trace;
    }

    /**
     * @inheritdoc
     */
    public function isValid(): bool
    {
        return $this->status;
    }

    /**
     * @inheritdoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritdoc
     */
    public function getTrace(): array
    {
        return $this->trace;
    }
}
