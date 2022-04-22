<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;
use Marsskom\Generator\Model\Scope\ScopeVariable;
use Marsskom\Generator\Model\Scope\Variable\Registry;
use Marsskom\Generator\Model\Variable\RegistryCollection\DefaultRegistryCollection;
use Marsskom\Generator\Test\Unit\Mock\Variable\DefaultRegistryCollection as TestDefaultCollection;

class ScopeVariableFactory
{
    /**
     * Returns mocked scope variable.
     *
     * @return ScopeVariableInterface
     */
    public function create(): ScopeVariableInterface
    {
        return new ScopeVariable(new Registry([
            new DefaultRegistryCollection(),
            new TestDefaultCollection(),
        ]));
    }
}
