<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable\Collection;

use Marsskom\Generator\Api\Data\Variable\VariableCollectionInterface;
use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Variable\Variable;

class DefaultCollection implements VariableCollectionInterface
{
    /**
     * @inheritdoc
     */
    public function variables(): array
    {
        return [
            new Variable(
                TemplateVariable::MODULE_NAME,
                VariableInterface::IS_SIMPLE
            ),
            new Variable(
                TemplateVariable::FILE_ANNOTATION,
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
            new Variable(
                TemplateVariable::FILE_NAMESPACE,
                VariableInterface::IS_SIMPLE
            ),
            new Variable(
                TemplateVariable::FILE_USES
            ),
            new Variable(
                TemplateVariable::CLASS_ANNOTATION,
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
            new Variable(
                TemplateVariable::CLASS_NAME,
                VariableInterface::IS_SIMPLE
            ),
            new Variable(
                TemplateVariable::CLASS_EXTENDS
            ),
            new Variable(
                TemplateVariable::CLASS_IMPLEMENTS
            ),
            new Variable(
                TemplateVariable::CLASS_PROPERTIES
            ),
            new Variable(
                TemplateVariable::INTERFACE_ANNOTATION,
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
            new Variable(
                TemplateVariable::INTERFACE_NAME,
                VariableInterface::IS_SIMPLE
            ),
            new Variable(
                TemplateVariable::METHODS
            ),
        ];
    }
}
