<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Validator;

use Marsskom\Generator\Exception\ValidateException;
use Marsskom\Generator\Model\Validator\Validator;

class EmptyValidator extends Validator
{
    /**
     * @inheritdoc
     */
    protected function concreteValidate(array $userInput): void
    {
        if (empty($userInput)) {
            throw new ValidateException(__("User input is empty"));
        }
    }
}
