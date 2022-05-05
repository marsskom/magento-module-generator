<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Context;

use Marsskom\Generator\Domain\Interfaces\Context\ContextIdInterface;

class ContextId implements ContextIdInterface
{
    private string $alias;

    /**
     * Context id constructor.
     *
     * @param string $alias
     */
    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }

    /**
     * @inheritdoc
     */
    public function value()
    {
        return $this->alias;
    }
}
