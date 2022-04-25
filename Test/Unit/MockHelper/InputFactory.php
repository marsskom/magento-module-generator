<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Scope\InputInterface;
use Marsskom\Generator\Model\Scope\Input;

class InputFactory
{
    /**
     * Returns mocked input scope.
     *
     * @param array $userInput
     *
     * @return InputInterface
     */
    public function create(array $userInput): InputInterface
    {
        return new Input($userInput);
    }
}
