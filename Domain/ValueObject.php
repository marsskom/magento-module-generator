<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain;

use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;

class ValueObject implements ValueObjectInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * Value object constructor.
     *
     * @param $value
     */
    public function __construct($value)
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
