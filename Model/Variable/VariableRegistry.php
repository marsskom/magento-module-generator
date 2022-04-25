<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableInterface;

class VariableRegistry
{
    private string $name;

    private int $options;

    /**
     * Callback for `call_user_func`
     *
     * @var null|callable|mixed
     */
    private $stringRepresentationClosure;

    /**
     * Variable registry constructor.
     *
     * @param string              $name
     * @param int                 $options
     * @param null|callback|mixed $stringRepresentationClosure - `call_user_func` callback
     */
    public function __construct(
        string $name,
        int $options = VariableInterface::DEFAULT,
        $stringRepresentationClosure = null
    ) {
        $this->name = $name;
        $this->options = $options;
        $this->stringRepresentationClosure = $stringRepresentationClosure;
    }

    /**
     * Returns variable name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns variable options.
     *
     * @return int
     */
    public function getOptions(): int
    {
        return $this->options;
    }

    /**
     * Returns string representation closure.
     *
     * @return null|callable|mixed
     */
    public function getStringRepresentation()
    {
        return $this->stringRepresentationClosure;
    }
}
