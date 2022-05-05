<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces;

interface CloneableInterface
{
    /**
     * Clones object.
     *
     * @return mixed
     */
    public function __clone();
}
