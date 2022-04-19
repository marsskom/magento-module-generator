<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Console;

use Marsskom\Generator\Exception\ValidateException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Validator\Validator;
use function preg_match;

class NameValidator extends Validator
{
    /**
     * @inheritdoc
     */
    protected function concreteValidate(array $userInput): void
    {
        $name = $userInput[InputParameter::NAME] ?? '';

        if (empty($userInput[InputParameter::NAME])) {
            throw new ValidateException(__("Name is required."));
        }

        if (false === (bool) preg_match('/^[\w_-]+?$/', $name)) {
            throw new ValidateException(__("Name may contain characters, underscore (_) and minus (-) only."));
        }
    }
}
