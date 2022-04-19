<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Validator;

interface ValidatorInterface
{
    /**
     * Adds next validator into chain.
     *
     * @param ValidatorInterface $validator
     *
     * @return ValidatorInterface
     */
    public function setNext(ValidatorInterface $validator): ValidatorInterface;

    /**
     * Validates user input.
     *
     * @param array $userInput
     *
     * @return ValidateResultInterface
     */
    public function validate(array $userInput): ValidateResultInterface;
}
