<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\Context;

use Generator;
use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\CloneableInterface;
use Marsskom\Generator\Domain\Interfaces\Context\ContextIdInterface;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Repository\ContextRepositoryInterface;
use function sprintf;

class ArrayRepository implements ContextRepositoryInterface, CloneableInterface
{
    /**
     * @var array<string, ContextInterface>
     */
    private array $repository = [];

    /**
     * @inheritdoc
     */
    public function has(ContextIdInterface $contextId): bool
    {
        return isset($this->repository[$contextId->value()]);
    }

    /**
     * @inheritdoc
     */
    public function add(ContextInterface $context): ContextRepositoryInterface
    {
        $contextIdValue = $context->id()->value();

        if ($this->has($context->id())) {
            throw new ContextAlreadyExistsException(
                sprintf("Context with id '%s' already exists", $contextIdValue)
            );
        }

        $new = clone $this;
        $new->repository[$contextIdValue] = $context;

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function remove(ContextIdInterface $contextId): ContextRepositoryInterface
    {
        if (!$this->has($contextId)) {
            throw new ContextNotFoundException(
                sprintf("Context with id '%s' not found", $contextId->value())
            );
        }

        $new = clone $this;
        unset($new->repository[$contextId->value()]);

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function get(ContextIdInterface $contextId): ContextInterface
    {
        if (!$this->has($contextId)) {
            throw new ContextNotFoundException(
                sprintf("Context with id '%s' not found", $contextId->value())
            );
        }

        return $this->repository[$contextId->value()];
    }

    /**
     * @inheritdoc
     */
    public function list(): Generator
    {
        foreach ($this->repository as $context) {
            yield $context;
        }
    }

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        $repository = [];
        foreach ($this->repository as $key => $repo) {
            $repository[$key] = clone $repo;
        }
        $this->repository = $repository;
    }
}
