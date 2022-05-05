<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Scope;

use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;

interface ScopeFactoryInterface
{
    /**
     * Creates scope where context was replaced.
     *
     * @param ScopeInterface   $scope
     * @param ContextInterface $context
     *
     * @return ScopeInterface
     */
    public function createWithReplacedContext(
        ScopeInterface $scope,
        ContextInterface $context
    ): ScopeInterface;
}
