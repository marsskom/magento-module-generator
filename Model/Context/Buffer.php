<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;

class Buffer
{
    private ScopeInterface $originalScope;

    /**
     * Buffer constructor.
     *
     * @param ScopeInterface $scope
     */
    public function __construct(
        ScopeInterface $scope
    ) {
        $this->originalScope = clone $scope;
    }

    /**
     * Returns original scope.
     *
     * @return ScopeInterface
     */
    public function restore(): ScopeInterface
    {
        return $this->originalScope;
    }
}
