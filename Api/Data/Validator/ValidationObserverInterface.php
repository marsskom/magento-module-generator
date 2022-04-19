<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Validator;

interface ValidationObserverInterface
{
    /**
     * Attaches validator into event by name.
     *
     * @param string             $eventName
     * @param ValidatorInterface $validator
     *
     * @return void
     */
    public function attach(string $eventName, ValidatorInterface $validator): void;

    /**
     * Notifies all observers which were attached by event name.
     *
     * @param string $eventName
     * @param array  $userInput
     *
     * @return ValidateResultInterface
     */
    public function notify(string $eventName, array $userInput): ValidateResultInterface;
}
