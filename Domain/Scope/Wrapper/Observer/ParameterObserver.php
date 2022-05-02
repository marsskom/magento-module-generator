<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Wrapper\Observer;

use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Domain\Scope\Context\ContextId;
use Marsskom\Generator\Domain\Scope\Helper\ArgFindHelper;
use Marsskom\Generator\Domain\Scope\Wrapper\Event\ParameterEventModel;

class ParameterObserver implements ObserverInterface
{
    /**
     * @inheritdoc
     *
     * @throws ContextNotFoundException
     */
    public function receive(
        SubjectInterface $subject,
        string $eventName,
        ValueObjectInterface $payload
    ): void {
        /** @var $subject CallableWrapper */
        /** @var $model ParameterEventModel */

        $model = $payload->value();

        $subject->value()->setParameters(
            $this->formParameters(
                $model->parameters(),
                $model->arguments()
            )
        );
    }

    /**
     * Returns specific parameters for the callable.
     *
     * @param array $parameters
     * @param array $args
     *
     * @return array
     *
     * @throws ContextNotFoundException
     */
    public function formParameters(array $parameters, array $args): array
    {
        $helper = new ArgFindHelper();

        /** @var $scope ScopeInterface */
        $scope = $helper->scope($args);

        $arguments = [];
        foreach ($parameters as $name) {
            $argument = null;

            switch ($name) {
                case 's':
                    $argument = $scope;
                    break;
                case 'c':
                    $argument = $helper->context($args) ??
                        $scope->repository()->get(
                            new ContextId($scope->getActiveContextAlias())
                        );
                    break;
                case 'i':
                    $argument = $helper->input($args) ?? $scope->input();
                    break;
                default:
                    continue 2;
            }

            $arguments[$name] = $argument;
        }

        return $arguments;
    }
}
