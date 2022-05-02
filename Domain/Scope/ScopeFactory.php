<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Context\ContextAlreadyExistsException;
use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeFactoryInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;

class ScopeFactory implements ScopeFactoryInterface
{
    /**
     * @inheritdoc
     *
     * @throws ContextNotFoundException
     * @throws ContextAlreadyExistsException
     */
    public function createWithReplacedContext(ScopeInterface $scope, ContextInterface $context): ScopeInterface
    {
        return (new ScopeBuilder())->build(
            $scope->repository()
                  ->remove($context->id())
                  ->add($context),
            $scope->input()
        )->setActiveContextAlias($scope->getActiveContextAlias());
    }
}
