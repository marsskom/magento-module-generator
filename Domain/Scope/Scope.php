<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Repository\ContextRepositoryInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Observer\Subject;
use Marsskom\Generator\Domain\Scope\Context\ContextId;

class Scope extends Subject implements ScopeInterface
{
    private ContextRepositoryInterface $repository;

    private InputInterface $input;

    private string $activeContextAlias = '';

    /**
     * Scope constructor.
     *
     * @param ContextRepositoryInterface $repository
     * @param InputInterface             $input
     */
    public function __construct(ContextRepositoryInterface $repository, InputInterface $input)
    {
        $this->repository = $repository;
        $this->input = $input;
    }

    /**
     * @inheritdoc
     */
    public function context(string $alias): ScopeInterface
    {
        $context = new Context(new ContextId($alias));

        $new = clone $this;
        $new->repository = $this->repository->add($context);
        $new->activeContextAlias = $alias;

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function current(string $alias): ScopeInterface
    {
        $this->repository->get(new ContextId($alias));

        $new = clone $this;
        $new->activeContextAlias = $alias;

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function what(): string
    {
        return $this->activeContextAlias;
    }

    /**
     * @inheritdoc
     */
    public function use(string $alias): ContextInterface
    {
        $contextId = new ContextId($alias);

        return $this->repository->get($contextId);
    }

    /**
     * @inheritdoc
     */
    public function repository(): ContextRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @inheritdoc
     */
    public function input(): InputInterface
    {
        return $this->input;
    }

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        parent::__clone();

        $this->repository = clone $this->repository;
        $this->input = clone $this->input;
    }
}
