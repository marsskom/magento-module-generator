<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Helper\Context\IdHelper;
use Marsskom\Generator\Model\Helper\Context\Validator;
use Marsskom\Generator\Model\Scope\Scope;
use Marsskom\Generator\Model\Scope\ScopeVariableBuilder;
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
        $mock = Mockery::mock(ScopeVariableBuilder::class);
        $mock->shouldReceive('create')
             ->andReturnUsing(static function () {
                 return (new ScopeVariableFactory())->create();
             });

        return new Scope(
            (new ContextFactory())->create(),
            (new InputFactory())->create($userInput),
            Mockery::mock(InterruptInterface::class),
            $mock,
            new IdHelper(),
            new Validator()
        );
    }
}
