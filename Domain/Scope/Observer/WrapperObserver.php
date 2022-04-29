<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Observer;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Domain\Scope\Scope;

class WrapperObserver implements ObserverInterface
{
    /**
     * @inheritdoc
     *
     * @throws ContextAlreadyExistsException
     * @throws ContextNotFoundException
     */
    public function receive(
        SubjectInterface $subject,
        string $eventName,
        ValueObjectInterface $payload
    ): void {
        /** @var $subject CallableWrapper */
        switch ($eventName) {
            case CallableWrapper::FORM_PARAMETER_EVENT:
                $subject->setCallableParameters($this->formParameters(
                    $payload->value()['parameters'],
                    $payload->value()['arguments']
                ));
                break;
            case CallableWrapper::PREPARE_SCOPE_EVENT:
                $subject->setCallableScope(
                    $this->prepareScope(
                        $payload->value()['scope'],
                        $payload->value()['result']
                    )
                );
                break;
        }
    }

    /**
     * Returns specific parameters for the callable.
     *
     * @param array $parameters
     * @param array $args
     *
     * @return array
     */
    public function formParameters(array $parameters, array $args): array
    {
        /** @var $scope ScopeInterface */
        $scope = $this->getByClass($args, ScopeInterface::class);

        $arguments = [];
        foreach ($parameters as $name) {
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
    public function prepareScope(ScopeInterface $scope, $result): ScopeInterface
    {
        switch (true) {
            case $result instanceof ScopeInterface:
                return $result;
            case $result instanceof ContextInterface:
                return new Scope(
                    $scope->repository()
                          ->remove($result->id())
                          ->add($result),
                    $scope->input()
                );
        }

        return $scope;
    }
}
