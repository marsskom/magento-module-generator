<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces;

interface ValueObjectInterface
{
    /**
     * Returns value.
     *
     * @return mixed
     */
    public function value();
}
