<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;
use Marsskom\Generator\Model\Scope\ScopeVariable;
use Marsskom\Generator\Model\Scope\Variable\Collection;
use Marsskom\Generator\Model\Variable\Collection\DefaultCollection;
use Marsskom\Generator\Test\Unit\Mock\Variable\DefaultCollection as TestDefaultCollection;

class ScopeVariableFactory
{
    /**
     * Returns mocked scope variable.
     *
     * @return ScopeVariableInterface
     */
    public function create(): ScopeVariableInterface
    {
        return new ScopeVariable(new Collection([
            new DefaultCollection(),
            new TestDefaultCollection(),
        ]));
    }
}
