<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Context;

use Marsskom\Generator\Domain\Interfaces\Context\VariableInterface;

class Variable implements VariableInterface
{
    private string $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Variable constructor.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function __construct(string $name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function value()
    {
        return $this->value;
    }
}
