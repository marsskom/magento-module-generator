<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation\Writer;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class ScopeWriter extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        foreach ($scope->walk() as $concreteScope) {
            foreach ($this->children as $child) {
                $child->execute($concreteScope);
            }
        }

        return $scope;
    }
}
