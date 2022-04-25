<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

interface CloneableInterface
{
    /**
     * Clone method.
     *
     * @return void
     */
    public function __clone();
}
