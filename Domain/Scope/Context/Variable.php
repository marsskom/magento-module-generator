<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Context;

use Marsskom\Generator\Domain\Interfaces\CloneableInterface;
use Marsskom\Generator\Domain\Interfaces\Context\VariableInterface;
use function is_callable;

class Variable implements VariableInterface, CloneableInterface
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

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        if (is_callable($this->value)) {
            $this->value = clone $this->value;
        }
    }
}
