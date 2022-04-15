<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Generator;

interface StubGeneratorInterface
{
    /**
     * Returns stub name.
     *
     * @return string
     */
    public function getStubName(): string;
}
