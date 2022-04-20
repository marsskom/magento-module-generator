<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Console;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Console\Command\Console\ConsoleCommandCommand;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class CommandGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $userInput = $context->getUserInput();
        $variables = $context->getVariables();

        $variables['command_name'] = $userInput[ConsoleCommandCommand::COMMAND_NAME_PARAMETER];
        $variables['command_description'] = $userInput[ConsoleCommandCommand::COMMAND_DESC_PARAMETER];

        return $context->setVariables($variables);
    }
}
