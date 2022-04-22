<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Scope\Scope;
use Mockery;

class ScopeFactory
{
    /**
     * Returns mocked scope.
     *
     * @param array $userInput
     *
     * @return ScopeInterface
     */
    public function create(array $userInput): ScopeInterface
    {
        return new Scope(
            (new ContextFactory())->create(),
            (new InputFactory())->create($userInput),
            (new ScopeVariableFactory())->create(),
            Mockery::mock(InterruptInterface::class)
        );
    }
}
