<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

interface GeneratorInterface
{
    /**
     * Executes all sequences and generators.
     *
     * @param ContextInterface $context
     *
     * @return ContextInterface
     */
    public function execute(ContextInterface $context): ContextInterface;
}
