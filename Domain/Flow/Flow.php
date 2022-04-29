<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Flow;

use Marsskom\Generator\Domain\Interfaces\Callables\CallableBuilderInterface;
use Marsskom\Generator\Domain\Interfaces\CloneableInterface;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\Input\ValidatorInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use function array_map;
use function array_merge;
use function is_array;
use function is_callable;

class Flow implements FlowInterface, CloneableInterface
{
    /**
     * @var ValidatorInterface[]
     */
    private array $validators = [];

    /**
     * @var array<string, callable[]|array>
     */
    private array $callables = [];

    private CallableBuilderInterface $builder;

    /**
     * @inheritdoc
     */
    public function validator($validator): FlowInterface
    {
        $validators = is_array($validator) ? $validator : [$validator];

        $new = clone $this;
        $new->validators = array_merge($this->validators, $validators);

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function with(string $alias, array $callables): FlowInterface
    {
        $new = clone $this;
        $new->callables[$alias] = array_merge(
            $new->callables[$alias] ?? [],
            $callables
        );

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function builder(CallableBuilderInterface $builder): FlowInterface
    {
        $new = clone $this;
        $new->builder = $builder;

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function run(): ScopeInterface
    {
        // TODO: Build callbacks, run and return scope.
    }

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        $this->builder = clone $this->builder;

        $this->validators = array_map(static fn(ValidatorInterface $v) => clone $v, $this->validators);

        $callables = [];
        foreach ($this->callables as $alias => $array) {
            foreach ($array as $callable) {
                $callables[$alias][] = is_callable($callable) ? clone $callable : $callable;
            }
        }
        $this->callables = $callables;
    }
}
