<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class PhpFileNameGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->context()->setFileName(
            $scope->input()->get(InputParameter::NAME) . '.php'
        );

        return $scope;
    }
}
