<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class InterfaceGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     *
     * @throws VariableAlreadySetException
     * @throws VariableNotExistsException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->var()->set(
            TemplateVariable::INTERFACE_NAME,
            // TODO: Maybe 'Interface' may be replaced with current filename from context, without extension.
            $scope->input()->get(InputParameter::NAME) . 'Interface'
        );

        return $scope;
    }
}
