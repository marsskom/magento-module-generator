<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Foundation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;

class Sequence extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        foreach ($this->children as $child) {
            $scope = $child->execute($scope);
        }

        return $scope;
    }
}
