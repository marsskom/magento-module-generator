<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class ClassNameGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     *
     * @throws VariableNotExistsException
     * @throws VariableAlreadySetException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->var()->set(
            TemplateVariable::CLASS_NAME,
            $scope->input()->get(InputParameter::NAME)
        );

        return $scope;
    }
}
