<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Console;

use Marsskom\Generator\Api\Data\Validator\ValidateResultInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;

/**
 * Mocked command that does nothing.
 */
class Command
{
    private ValidationObserverInterface $validationObserver;

    /**
     * Command constructor.
     *
     * @param ValidationObserverInterface $validationObserver
     */
    public function __construct(
        ValidationObserverInterface $validationObserver
    ) {
        $this->validationObserver = $validationObserver;
    }

    /**
     * Common execute method.
     *
     * @param array $userInput
     *
     * @return ValidateResultInterface
     */
    public function execute(array $userInput): ValidateResultInterface
    {
        return $this->validationObserver->notify(__CLASS__, $userInput);
    }
}
