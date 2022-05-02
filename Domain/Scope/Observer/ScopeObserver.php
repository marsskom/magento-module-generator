<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Observer;

use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeFactoryInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Domain\Scope\Wrapper\Event\ScopeEventModel;

class ScopeObserver implements ObserverInterface
{
    private ScopeFactoryInterface $factory;

    /**
     * Scope observer constructor.
     *
     * @param ScopeFactoryInterface $factory
     */
    public function __construct(ScopeFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function receive(
        SubjectInterface $subject,
        string $eventName,
        ValueObjectInterface $payload
    ): void {
        /** @var $subject CallableWrapper */
        /** @var $model ScopeEventModel */

        $model = $payload->value();

        $subject->value()->setScope(
            $this->prepareScope(
                $model->scope(),
                $model->result()
            )
        );
    }

    /**
     * Forms callable scope result.
     *
     * @param ScopeInterface $scope
     * @param mixed          $result
     *
     * @return ScopeInterface
     */
    public function prepareScope(ScopeInterface $scope, $result): ScopeInterface
    {
        switch (true) {
            case $result instanceof ScopeInterface:
                return $result;
            case $result instanceof ContextInterface:
                return $this->factory->createWithReplacedContext($scope, $result);
        }

        return $scope;
    }
}
