<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use ReflectionException;
use ReflectionFunction;
use ReflectionParameter;

class WrapperHelper
{
    /**
     * Returns callable parameters.
     *
     * @param callable $callable
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function parameters(callable $callable): array
    {
        $reflection = new ReflectionFunction($callable);

        return array_map(
            static fn(ReflectionParameter $parameter) => $parameter->getName(),
            $reflection->getParameters()
        );
    }

    /**
     * Returns specific parameters for the callable.
     *
     * @param callable $callable
     * @param array    $args
     *
     * @return array
     *
     * @throws ReflectionException
     */
    public function assignParameters(callable $callable, array $args): array
    {
        /** @var $scope ScopeInterface */
        $scope = $this->getByClass($args, ScopeInterface::class);

        $arguments = [];
        foreach ($this->parameters($callable) as $name) {
            $argument = null;

            switch ($name) {
                case 's':
                    $argument = $scope;
                    break;
                case 'c':
                    $argument = $this->getByClass($args, ContextInterface::class);
                    if (null === $argument) {
                        $contextsList = iterator_to_array($scope->repository()->list());
                        $argument = array_pop($contextsList);
                    }
                    break;
                case 'i':
                    $argument = $this->getByClass($args, InputInterface::class) ?? $scope->input();
                    break;
                default:
                    continue 2;
            }

            $arguments[$name] = $argument;
        }

        return $arguments;
    }

    /**
     * Returns argument by class instance.
     *
     * @param array  $args
     * @param string $className
     *
     * @return null|mixed
     */
    public function getByClass(array $args, string $className)
    {
        foreach ($args as $arg) {
            if ($arg instanceof $className) {
                return $arg;
            }
        }

        return null;
    }

    /**
     * Forms callable scope result.
     *
     * @param ScopeInterface $scope
     * @param mixed          $result
     *
     * @return ScopeInterface
     *
     * @throws ContextAlreadyExistsException
     * @throws ContextNotFoundException
     */
    public function callableScopeResult(ScopeInterface $scope, $result): ScopeInterface
    {
        switch (true) {
            case $result instanceof ScopeInterface:
                $scope = $result;
                break;
            case $result instanceof ContextInterface:
                $scope = new Scope(
                    $scope->repository()
                          ->remove($result->id())
                          ->add($result),
                    $scope->input()
                );
                break;
        }

        return $scope;
    }
}
