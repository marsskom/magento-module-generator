<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces;

use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;

interface FlowInterface
{
    /**
     * Adds input validator.
     *
     * @param callable|callable[] $validator
     *
     * @return FlowInterface
     */
    public function validator($validator): FlowInterface;

    /**
     * Sets or adds callable methods for context.
     *
     * @param string                   $alias
     * @param callable[]|array[]|mixed $callables
     *
     * @return FlowInterface
     */
    public function with(string $alias, array $callables): FlowInterface;

    /**
     * Runs flow.
     *
     * @param ScopeInterface $scope - scope that will be changed
     *
     * @return ScopeInterface
     */
    public function run(ScopeInterface $scope): ScopeInterface;
}
