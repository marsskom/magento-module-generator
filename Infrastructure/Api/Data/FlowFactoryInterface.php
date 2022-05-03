<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Api\Data;

use Marsskom\Generator\Domain\Interfaces\FlowInterface;

interface FlowFactoryInterface
{
    /**
     * Returns bare flow.
     *
     * @return FlowInterface
     */
    public function create(): FlowInterface;
}
