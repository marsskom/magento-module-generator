<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Sequence;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class FakeContextRegister extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->context()->setPath(
            $scope->input()->get(InputParameter::PATH)
        );
        $scope->context()->setFileName(
            $scope->input()->get(InputParameter::NAME)
        );

        return $scope->registerContext($scope->context());
    }
}
