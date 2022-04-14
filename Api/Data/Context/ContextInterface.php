<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

interface ContextInterface
{
    /**
     * Returns input context.
     *
     * @return InputInterface
     */
    public function input(): InputInterface;

    /**
     * Returns output context.
     *
     * @return OutputInterface
     */
    public function output(): OutputInterface;
}
