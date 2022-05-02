<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Observer;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Marsskom\Generator\Domain\Scope\CallableWrapper;
use Marsskom\Generator\Domain\Scope\Scope;
use Marsskom\Generator\Domain\Scope\Wrapper\Event\ScopeEventModel;

class ScopeObserver implements ObserverInterface
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
