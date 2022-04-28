<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Scope;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Repository\ContextRepositoryInterface;

interface ScopeInterface
{
    /**
     * Adds or updates context with callables.
     *
     * @param string $alias
     *
     * @return ScopeInterface
     *
     * @throws ContextAlreadyExistsException
     */
    public function context(string $alias): ScopeInterface;

    /**
     * Passes access into context object by the alias.
     *
     * @param string $alias
     *
     * @return ContextInterface
     *
     * @throws ContextNotFoundException
     */
    public function use(string $alias): ContextInterface;

    /**
     * Passes access into context repository.
     *
     * @return ContextRepositoryInterface
     */
    public function repository(): ContextRepositoryInterface;

    /**
     * Passes access into input object.
     *
     * @return InputInterface
     */
    public function input(): InputInterface;
}
