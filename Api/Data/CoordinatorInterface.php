<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

interface CoordinatorInterface
{
    /**
     * Creates context.
     *
     * @return CoordinatorInterface
     */
    public function create(): CoordinatorInterface;

    /**
     * Returns context.
     *
     * @return ContextInterface
     */
    public function get(): ContextInterface;
}
