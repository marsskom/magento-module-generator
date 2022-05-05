<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Context;

use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;

interface VariableInterface extends ValueObjectInterface
{
    /**
     * Returns variable's name.
     *
     * @return string
     */
    public function name(): string;
}
