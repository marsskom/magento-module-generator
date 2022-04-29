<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces;

use Marsskom\Generator\Domain\Interfaces\Callables\CallableBuilderInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\Input\ValidatorInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;

interface FlowInterface
{
    /**
     * Adds input validator.
     *
     * @param ValidatorInterface[]|ValidatorInterface $validator
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
     * Sets flow builder.
     *
     * @param CallableBuilderInterface $builder
     *
     * @return FlowInterface
     */
    public function builder(CallableBuilderInterface $builder): FlowInterface;

    /**
     * Runs flow.
     *
     * @return ScopeInterface
     */
    public function run(): ScopeInterface;
}
