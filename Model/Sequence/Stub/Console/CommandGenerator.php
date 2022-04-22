<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Console;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Console\Command\Console\ConsoleCommandCommand;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class CommandGenerator extends AbstractSequence
{
    /**
     * @inheritdoc
     *
     * @throws VariableNotExistsException
     * @throws VariableAlreadySetException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        // TODO: Vars names should be registered in Collection
        $scope->var()->set(
            'command_name',
            $scope->input()->get(ConsoleCommandCommand::COMMAND_NAME_PARAMETER)
        );

        $scope->var()->set(
            'command_description',
            $scope->input()->get(ConsoleCommandCommand::COMMAND_DESC_PARAMETER)
        );

        return $scope;
    }
}
