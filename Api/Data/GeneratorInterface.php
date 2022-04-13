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

    /**
     * Sets next middleware-generator.
     *
     * @param GeneratorInterface $middleware
     */
    public function setNextMiddleware(GeneratorInterface $middleware): void;

    /**
     * Returns next middleware.
     *
     * @return null|GeneratorInterface
     */
    public function next(): ?GeneratorInterface;
}
