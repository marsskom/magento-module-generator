<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Console\Command\EntityCommand;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class DataObjectExtendsGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        if (!$context->getUserInput()[EntityCommand::COMMAND_IS_DATA_OBJECT_PARAMETER]) {
            return $context;
        }

        $variables = $context->getVariables();
        $variables[TemplateVariable::FILE_USES][] = 'use Magento\Framework\DataObject;';
        $variables[TemplateVariable::CLASS_EXTENDS] = ' extends DataObject';

        return $context->setVariables($variables);
    }
}
