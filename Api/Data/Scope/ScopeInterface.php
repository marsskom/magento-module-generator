<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Scope;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;

/**
 * @method ScopeVariableInterface var() Returns scope variables interface for context.
 */
interface ScopeInterface
{
    /**
     * Returns context interface.
     *
     * @return ContextInterface
     */
    public function context(): ContextInterface;

    /**
     * Returns input interface.
     *
     * @return InputInterface
     */
    public function input(): InputInterface;

    /**
     * Returns interrupt object.
     *
     * @return InterruptInterface
     */
    public function interrupt(): InterruptInterface;
}
