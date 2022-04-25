<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Generator;

use Marsskom\Generator\Api\Data\SequenceInterface;

interface ContextRegisterGeneratorInterface
{
    /**
     * Returns contexts.
     *
     * @return array<string, SequenceInterface[]>
     */
    public function getContexts(): array;
}
