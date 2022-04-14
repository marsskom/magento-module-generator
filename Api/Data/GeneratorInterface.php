<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Context\ContextInterface;

interface GeneratorInterface
{
    /**
     * Generates code based on context.
     *
     * @param ContextInterface $context
     *
     * @return ContextInterface
     */
    public function execute(ContextInterface $context): ContextInterface;
}
