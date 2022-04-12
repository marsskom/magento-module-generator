<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Context\InputInterface;
use Marsskom\Generator\Api\Data\Context\OutputInterface;

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
