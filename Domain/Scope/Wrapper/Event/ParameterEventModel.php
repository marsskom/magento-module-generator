<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Wrapper\Event;

class ParameterEventModel
{
    private array $parameters;

    private array $arguments;

    /**
     * Event model constructor.
     *
     * @param array $parameters
     * @param array $arguments
     */
    public function __construct(array $parameters, array $arguments)
    {
        $this->parameters = $parameters;
        $this->arguments = $arguments;
    }

    /**
     * Returns parameters.
     *
     * @return array
     */
    public function parameters(): array
    {
        return $this->parameters;
    }

    /**
     * Returns arguments.
     *
     * @return array
     */
    public function arguments(): array
    {
        return $this->arguments;
    }
}
