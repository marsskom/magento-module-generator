<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Mock\Observer;

use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;

class IntValue implements ValueObjectInterface
{
    private int $value;

    /**
     * Int value constructor.
     *
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function value()
    {
        return $this->value;
    }
}
