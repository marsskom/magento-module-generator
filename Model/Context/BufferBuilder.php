<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;

class BufferBuilder
{
    /**
     * Returns buffer.
     *
     * @param ScopeInterface $scope
     *
     * @return Buffer
     */
    public function create(ScopeInterface $scope): Buffer
    {
        return new Buffer($scope);
    }
}
