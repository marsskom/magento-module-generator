<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Callables\CallableInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Marsskom\Generator\Domain\Observer\Subject;
use Marsskom\Generator\Domain\Scope\Helper\ArgFindHelper;
use Marsskom\Generator\Domain\Scope\Wrapper\CallableValue;
use Marsskom\Generator\Domain\Scope\Wrapper\Event\ParameterEventModel;
use Marsskom\Generator\Domain\Scope\Wrapper\Event\ScopeEventModel;
use Marsskom\Generator\Domain\ValueObject;
use ReflectionException;
use ReflectionFunction;
use ReflectionParameter;
use function array_values;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class CallableWrapper extends Subject implements CallableInterface, ValueObjectInterface
{
    public const FORM_PARAMETER_EVENT = __CLASS__ . '-form_parameter_event';

    public const PREPARE_SCOPE_EVENT = __CLASS__ . '-prepare_scope';

    /**
     * @var callable
     */
    private $callable;

    private CallableValue $eventValue;

    /**
     * Scope callable wrapper constructor.
     *
     * @param callable $callable
     */
    public function __construct(
        callable $callable
    ) {
        $this->callable = $callable;
        $this->eventValue = new CallableValue();
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
        $scope = (new ArgFindHelper())->scope($args);
        if (null === $scope || !$this->hasObservers()) {
            return ($this->callable)(...$args);
        }

        $parameters = $this->parameters($this->callable);

        $this->trigger(
            self::FORM_PARAMETER_EVENT,
            new ValueObject(new ParameterEventModel($parameters, $args))
        );

        $result = ($this->callable)(...array_values(
            $this->eventValue->getParameters()
        ));

        $this->trigger(
            self::PREPARE_SCOPE_EVENT,
            new ValueObject(new ScopeEventModel($scope, $result))
        );

        return $this->eventValue->getScope();
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
        return array_map(
            static fn(ReflectionParameter $parameter) => $parameter->getName(),
            (new ReflectionFunction($callable))->getParameters()
        );
    }

    /**
     * @inheritdoc
     */
    public function value(): CallableValue
    {
        return $this->eventValue;
    }
}
