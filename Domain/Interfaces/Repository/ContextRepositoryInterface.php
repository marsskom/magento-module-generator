<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Repository;

use Generator;
use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextIdInterface;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;

interface ContextRepositoryInterface
{
    /**
     * Returns context existence state.
     *
     * @param ContextIdInterface $contextId
     *
     * @return bool
     */
    public function has(ContextIdInterface $contextId): bool;

    /**
     * Adds context into repository.
     *
     * @param ContextInterface $context
     *
     * @return ContextRepositoryInterface
     *
     * @throws ContextAlreadyExistsException
     */
    public function add(ContextInterface $context): ContextRepositoryInterface;

    /**
     * Removes context by id.
     *
     * @param ContextIdInterface $contextId
     *
     * @return ContextRepositoryInterface
     *
     * @throws ContextNotFoundException
     */
    public function remove(ContextIdInterface $contextId): ContextRepositoryInterface;

    /**
     * Returns context by id.
     *
     * @param ContextIdInterface $contextId
     *
     * @return ContextInterface
     *
     * @throws ContextNotFoundException
     */
    public function get(ContextIdInterface $contextId): ContextInterface;

    /**
     * Walks by all contexts in repository.
     *
     * @return Generator|ContextInterface[]
     */
    public function list(): Generator;
}
