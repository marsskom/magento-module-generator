<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

use Marsskom\Generator\Api\Data\ArrayInterface;

interface InputInterface extends ArrayInterface
{
    /**
     * Returns stub name.
     *
     * @return string
     */
    public function getStubName(): string;
}
