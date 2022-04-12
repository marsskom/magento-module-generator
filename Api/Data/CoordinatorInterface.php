<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

interface CoordinatorInterface
{
    /**
     * Creates context.
     *
     * @return ContextInterface
     */
    public function createContext(): ContextInterface;
}
