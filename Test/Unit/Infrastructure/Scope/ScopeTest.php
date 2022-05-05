<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Infrastructure\Scope;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Scope\Input;
use Marsskom\Generator\Domain\Scope\Scope;
use Marsskom\Generator\Infrastructure\Model\Context\ArrayRepository;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ScopeTest extends MockeryTestCase
{
    /**
     * Test immutability.
     *
     * @return void
     *
     * @throws ContextAlreadyExistsException
     * @throws ContextNotFoundException
     */
    public function testImmutability(): void
    {
        $scope = (new Scope(new ArrayRepository(), new Input([])))
            ->context('default');
        $secondScope = $scope->context('second');

        $this->assertInstanceOf(
            ContextInterface::class,
            $scope->use('default')
        );

        $this->assertInstanceOf(
            ContextInterface::class,
            $secondScope->use('default')
        );
        $this->assertInstanceOf(
            ContextInterface::class,
            $secondScope->use('second')
        );
    }

    /**
     * Test add context method.
     *
     * @return void
     *
     * @throws ContextAlreadyExistsException
     * @throws ContextNotFoundException
     */
    public function testAddContext(): void
    {
        $scope = (new Scope(new ArrayRepository(), new Input([])))
            ->context('default');

        $this->assertInstanceOf(
            ContextInterface::class,
            $scope->use('default')
        );
    }
}
