<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\ContextInterface;

class Buffer
{
    private ContextInterface $originalContext;

    /**
     * Buffer constructor.
     *
     * @param ContextInterface $context
     */
    public function __construct(
        ContextInterface $context
    ) {
        $this->originalContext = clone $context;
    }

    /**
     * Returns original context.
     *
     * @return ContextInterface
     */
    public function restore(): ContextInterface
    {
        return $this->originalContext;
    }
}
