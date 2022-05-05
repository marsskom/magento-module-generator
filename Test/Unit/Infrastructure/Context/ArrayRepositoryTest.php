<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Infrastructure\Context;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Scope\Context;
use Marsskom\Generator\Domain\Scope\Context\ContextId;
use Marsskom\Generator\Infrastructure\Model\Context\ArrayRepository;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ArrayRepositoryTest extends MockeryTestCase
{
    /**
     * Tests immutability.
     *
     * @return void
     *
     * @throws ContextAlreadyExistsException
     */
    public function testImmutability(): void
    {
        $contextId = new ContextId('default');
        $secondContextId = new ContextId('second');

        $repository = (new ArrayRepository())->add(new Context($contextId));
        $secondRepository = $repository->add(new Context($secondContextId));

        $this->assertFalse($repository->has($secondContextId));
        $this->assertTrue($secondRepository->has($contextId));
        $this->assertTrue($secondRepository->has($secondContextId));
    }

    /**
     * Tests repository add method.
     *
     * @return void
     *
     * @throws ContextAlreadyExistsException
     */
    public function testRepositoryAdd(): void
    {
        $contextId = new ContextId('default');
        $repository = (new ArrayRepository())->add(new Context($contextId));

        $this->assertTrue($repository->has($contextId));
    }

    /**
     * Tests repository add method with exception.
     *
     * @return void
     */
    public function testRepositoryAddException(): void
    {
        $this->expectException(ContextAlreadyExistsException::class);

        $contextId = new ContextId('default');
        (new ArrayRepository())
            ->add(new Context($contextId))
            ->add(new Context($contextId));
    }

    /**
     * Tests repository remove method.
     *
     * @return void
     *
     * @throws ContextAlreadyExistsException
     * @throws ContextNotFoundException
     */
    public function testRepositoryRemove(): void
    {
        $contextId = new ContextId('default');
        $repository = (new ArrayRepository())
            ->add(new Context($contextId))
            ->remove($contextId);

        $this->assertFalse($repository->has($contextId));
    }

    /**
     * Tests repository remove method with context not found exception.
     *
     * @return void
     */
    public function testRepositoryRemoveNotFoundException(): void
    {
        $this->expectException(ContextNotFoundException::class);

        $contextId = new ContextId('default');
        (new ArrayRepository())->remove($contextId);
    }

    /**
     * Tests get method.
     *
     * @return void
     *
     * @throws ContextAlreadyExistsException
     * @throws ContextNotFoundException
     */
    public function testGetMethod(): void
    {
        $contextId = new ContextId('default');
        $repository = (new ArrayRepository())
            ->add(new Context($contextId));

        $this->assertInstanceOf(
            ContextInterface::class,
            $repository->get($contextId)
        );
    }

    /**
     * Tests get method with not found exception.
     *
     * @return void
     */
    public function testGetNotFoundException(): void
    {
        $this->expectException(ContextNotFoundException::class);

        $contextId = new ContextId('default');
        (new ArrayRepository())->get($contextId);
    }

    /**
     * Tests list method.
     *
     * @return void
     *
     * @throws ContextAlreadyExistsException
     */
    public function testList(): void
    {
        $contextIds = [
            new ContextId('default'),
            new ContextId('first'),
            new ContextId('second'),
        ];

        $repository = new ArrayRepository();
        foreach ($contextIds as $id) {
            $repository = $repository->add(new Context($id));
        }

        foreach ($repository->list() as $key => $context) {
            $this->assertEquals(
                $contextIds[$key]->value(),
                $context->id()->value()
            );
        }
    }
}
