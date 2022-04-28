<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Callables;

interface CallableInterface
{
    /**
     * Invoke magic method.
     *
     * @param mixed $args
     *
     * @return mixed
     */
    public function __invoke(...$args);
}
