<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Callables;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Scope\WrapperHelper;
use ReflectionException;
use function array_values;

class ScopeCallableWrapper implements CallableInterface
{
    /**
     * @var callable
     */
    private $callable;

    private WrapperHelper $helper;

    /**
     * Scope callable wrapper constructor.
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
        $this->helper = new WrapperHelper();
    }

    /**
     * @inheritdoc
     *
     * @throws ReflectionException
     * @throws ContextNotFoundException
     * @throws ContextAlreadyExistsException
     */
    public function __invoke(...$args)
    {
        $scope = $this->helper->getByClass($args, ScopeInterface::class);
        if (null === $scope) {
            return ($this->callable)(...$args);
        }

        /** @var $scope ScopeInterface */

        $arguments = $this->helper->assignParameters($this->callable, $args);

        $result = ($this->callable)(...array_values($arguments));

        return $this->helper->callableScopeResult($scope, $result);
    }
}
