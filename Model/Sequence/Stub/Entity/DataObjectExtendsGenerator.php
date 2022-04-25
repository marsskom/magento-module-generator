<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Console\Command\EntityCommand;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class DataObjectExtendsGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     *
     * @throws VariableIsNotMultipleException
     * @throws VariableNotExistsException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        if (!$scope->input()->get(EntityCommand::COMMAND_IS_DATA_OBJECT_PARAMETER)) {
            return $scope;
        }

        $scope->var()->add(
            TemplateVariable::FILE_USES,
            'use Magento\Framework\DataObject;'
        );
        $scope->var()->add(
            TemplateVariable::CLASS_EXTENDS,
            'DataObject'
        );

        return $scope;
    }
}
