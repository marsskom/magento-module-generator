<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
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
     * @throws VariableIsNotMultipleException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $interfaceName = $scope->input()->get(InputParameter::NAME) . 'Interface';

        $scope->var()->set(
            TemplateVariable::INTERFACE_NAME,
            $interfaceName
        );

        $scope->for(ScopeInterface::DEFAULT_CONTEXT)->add(
            TemplateVariable::FILE_USES,
            'use ' . $scope->var()->get(TemplateVariable::FILE_NAMESPACE) . '\\' . $interfaceName . ';'
        );
        $scope->for(ScopeInterface::DEFAULT_CONTEXT)->add(
            TemplateVariable::CLASS_IMPLEMENTS,
            $interfaceName
        );

        return $scope;
    }
}
