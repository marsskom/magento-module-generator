<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Observer\Subject;
use Marsskom\Generator\Domain\ValueObject;
use ReflectionException;
use ReflectionFunction;
use ReflectionParameter;
use function array_values;

class CallableWrapper extends Subject implements CallableInterface
{
    public const FORM_PARAMETER_EVENT = __CLASS__ . '-form_parameter_event';

    public const PREPARE_SCOPE_EVENT = __CLASS__ . '-prepare_scope';

    /**
     * @var callable
     */
    private $callable;

    private array $callableParameters = [];

    private ?ScopeInterface $callableScope = null;

    /**
     * Scope callable wrapper constructor.
     *
     * @param callable               $callable
     * @param null|ObserverInterface $observer
     */
    public function __construct(
        callable $callable,
        ?ObserverInterface $observer = null
    ) {
        $this->callable = $callable;

        if (null !== $observer) {
            $this->attach(self::FORM_PARAMETER_EVENT, $observer);
            $this->attach(self::PREPARE_SCOPE_EVENT, $observer);
        }
    }

    /**
     * @inheritdoc
     *
     * @throws ReflectionException
     * @throws ContextNotFoundException
     * @throws ContextAlreadyExistsException
     * @throws EventNameNotExistsException
     */
    public function __invoke(...$args)
    {
        $scope = null;
        foreach ($args as $arg) {
            if ($arg instanceof ScopeInterface) {
                $scope = $arg;
                break;
            }
        }

        if (null === $scope || !$this->hasObservers()) {
            return ($this->callable)(...$args);
        }

        /** @var $scope ScopeInterface */

        $parameters = $this->parameters($this->callable);

        $this->trigger(
            self::FORM_PARAMETER_EVENT,
            new ValueObject([
                'parameters' => $parameters,
                'arguments'  => $args,
            ])
        );
        $arguments = $this->getCallableParameters();

        $result = ($this->callable)(...array_values($arguments));

        $this->trigger(
            self::PREPARE_SCOPE_EVENT,
            new ValueObject([
                'scope'  => $scope,
                'result' => $result,
            ])
        );

        return $this->getCallableScope();
    }

    /**
     * Returns callable parameters.
     *
     * @param callable $callable
     *
     * @return array
     *
     * @throws ReflectionException
     */
    protected function parameters(callable $callable): array
    {
        $reflection = new ReflectionFunction($callable);

        return array_map(
            static fn(ReflectionParameter $parameter) => $parameter->getName(),
            $reflection->getParameters()
        );
    }

    /**
     * Returns callable parameters.
     *
     * @return array
     */
    public function getCallableParameters(): array
    {
        return $this->callableParameters;
    }

    /**
     * Sets callable parameters.
     *
     * @param array $callableParameters
     */
    public function setCallableParameters(array $callableParameters): void
    {
        $this->callableParameters = $callableParameters;
    }

    /**
     * Returns callable scope.
     *
     * @return null|ScopeInterface
     */
    public function getCallableScope(): ?ScopeInterface
    {
        return $this->callableScope;
    }

    /**
     * Sets callable scope.
     *
     * @param null|ScopeInterface $callableScope
     */
    public function setCallableScope(?ScopeInterface $callableScope): void
    {
        $this->callableScope = $callableScope;
    }
}
