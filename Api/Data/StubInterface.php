<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

interface StubInterface extends ArrayInterface
{
    /**
     * Returns stub key.
     *
     * @return string
     */
    public function getKey(): string;
}
