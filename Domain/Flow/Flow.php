<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Flow;

use Marsskom\Generator\Domain\Exception\Callables\IsNotCallableException;
use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableBuilderInterface;
use Marsskom\Generator\Domain\Interfaces\CloneableInterface;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\Input\ValidatorInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Pipeline\Pipeline;
use function array_keys;
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
     * Flow constructor.
     *
     * @param CallableBuilderInterface $builder
     */
    public function __construct(CallableBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @inheritdoc
     */
    public function validator($validator): FlowInterface
    {
        $validators = is_array($validator) ? $validator : [$validator];

        array_map(static fn(callable $c) => $c, $validators);

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
     *
     * @throws IsNotCallableException
     * @throws ContextAlreadyExistsException
     */
    public function run(ScopeInterface $scope): ScopeInterface
    {
        (new Pipeline(
            $this->builder->build($this->validators)
        ))($scope);

        // TODO: validator exception here.

        foreach (array_keys($this->callables) as $alias) {
            $scope = $scope->context($alias);
        }

        $pipelines = [];
        foreach ($this->callables as $alias => $callables) {
            $pipelines[] = new Pipeline($this->builder->build([
                static fn($s) => $s->current($alias),
            ]));
            $pipelines[] = new Pipeline($this->builder->build($callables));
        }

        return (new Pipeline($pipelines))($scope)[0];
    }

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        $this->builder = clone $this->builder;

        $this->validators = array_map(static fn(callable $v) => clone $v, $this->validators);

        $callables = [];
        foreach ($this->callables as $alias => $array) {
            foreach ($array as $callable) {
                $callables[$alias][] = is_callable($callable) ? clone $callable : $callable;
            }
        }
        $this->callables = $callables;
    }
}
