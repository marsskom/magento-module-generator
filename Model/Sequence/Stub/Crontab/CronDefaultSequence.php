<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Crontab;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Console\Command\Crontab\CronCommand;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Exception\Scope\VariableTypeException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class CronDefaultSequence extends AbstractSequence
{
    /**
     * @inheritdoc
     *
     * @throws VariableAlreadySetException
     * @throws VariableNotExistsException
     * @throws VariableTypeException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->for('group')->set(
            'cronjob_group',
            $scope->input()->get(CronCommand::COMMAND_GROUP)
        );

        $scope->for('crontab')->set(
            'cronjob_group',
            $scope->input()->get(CronCommand::COMMAND_GROUP)
        );
        $scope->for('crontab')->set(
            'cronjob_name',
            $scope->input()->get(InputParameter::NAME)
        );
        $scope->for('crontab')->set(
            'cronjob_class',
            $scope->var()->get(TemplateVariable::FILE_NAMESPACE)
            . '\\' . $scope->var()->get(TemplateVariable::CLASS_NAME)
        );
        $scope->for('crontab')->set(
            'cronjob_schedule',
            $scope->input()->get(CronCommand::COMMAND_SCHEDULE)
        );

        return $scope;
    }
}
