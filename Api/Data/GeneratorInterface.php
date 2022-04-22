<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;

interface GeneratorInterface
{
    /**
     * Generates code based on the scope.
     *
     * @param ScopeInterface $scope
     *
     * @return ScopeInterface
     */
    public function execute(ScopeInterface $scope): ScopeInterface;
}
