<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable\RegistryCollection;

use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Api\Data\Variable\VariableRegistryCollectionInterface;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Variable\Closures\DefaultClosures;
use Marsskom\Generator\Model\Variable\VariableRegistry;

class DefaultRegistryCollection implements VariableRegistryCollectionInterface
{
    /**
     * @inheritdoc
     */
    public function registries(): array
    {
        return [
            new VariableRegistry(
                TemplateVariable::MODULE_NAME,
                VariableInterface::IS_SIMPLE
            ),
            new VariableRegistry(
                TemplateVariable::FILE_ANNOTATION,
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
            new VariableRegistry(
                TemplateVariable::FILE_NAMESPACE,
                VariableInterface::IS_SIMPLE
            ),
            new VariableRegistry(
                TemplateVariable::FILE_USES,
                VariableInterface::DEFAULT,
                [DefaultClosures::class, 'implodeByNewLine'],
            ),
            new VariableRegistry(
                TemplateVariable::CLASS_ANNOTATION,
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
            new VariableRegistry(
                TemplateVariable::CLASS_NAME,
                VariableInterface::IS_SIMPLE
            ),
            new VariableRegistry(
                TemplateVariable::CLASS_EXTENDS,
                VariableInterface::DEFAULT,
                [DefaultClosures::class, 'implodeExtends'],
            ),
            new VariableRegistry(
                TemplateVariable::CLASS_IMPLEMENTS,
                VariableInterface::DEFAULT,
                [DefaultClosures::class, 'implodeImplements'],
            ),
            new VariableRegistry(
                TemplateVariable::CLASS_PROPERTIES,
            ),
            new VariableRegistry(
                TemplateVariable::INTERFACE_ANNOTATION,
                VariableInterface::IS_SIMPLE | VariableInterface::IS_REWRITABLE
            ),
            new VariableRegistry(
                TemplateVariable::INTERFACE_NAME,
                VariableInterface::IS_SIMPLE
            ),
            new VariableRegistry(
                TemplateVariable::METHODS
            ),
        ];
    }
}