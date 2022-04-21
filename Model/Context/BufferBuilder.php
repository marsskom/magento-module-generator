<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\ContextInterface;

class BufferBuilder
{
    /**
     * Returns buffer.
     *
     * @param ContextInterface $context
     *
     * @return Buffer
     */
    public function create(ContextInterface $context): Buffer
    {
        return new Buffer($context);
    }
}
