<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Scope;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;

interface ScopeInterface
{
    /**
     * Default context alias.
     */
    public const DEFAULT_CONTEXT = 'default';

    /**
     * Registers context for scope.
     *
     * @param ContextInterface $context
     * @param string           $alias
     *
     * @return ScopeInterface
     */
    public function registerContext(
        ContextInterface $context,
        string $alias = ScopeInterface::DEFAULT_CONTEXT
    ): ScopeInterface;

    /**
     * Sets current context.
     *
     * @param ContextInterface $context
     *
     * @return mixed
     */
    public function setCurrentContext(ContextInterface $context): ScopeInterface;

    /**
     * Sets current context from alias.
     *
     * @param string $alias
     *
     * @return ScopeInterface
     */
    public function setCurrentContextFromAlias(string $alias): ScopeInterface;

    /**
     * Returns current context interface.
     *
     * @return ContextInterface
     */
    public function context(): ContextInterface;

    /**
     * Returns input interface.
     *
     * @return InputInterface
     */
    public function input(): InputInterface;

    /**
     * Returns interrupt object.
     *
     * @return InterruptInterface
     */
    public function interrupt(): InterruptInterface;

    /**
     * Returns variables scope for current context.
     *
     * @return ScopeVariableInterface
     */
    public function var(): ScopeVariableInterface;

    /**
     * Returns variables scope for specific context.
     *
     * @param string $contextAlias
     *
     * @return ScopeVariableInterface
     */
    public function for(string $contextAlias): ScopeVariableInterface;
}
