<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Automation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class MultiplierGenerator extends AbstractSequence
{
    private int $multiplier;

    public function __construct(
        int $multiplier,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->multiplier = $multiplier;
    }

    /**
     * @inheritdoc
     *
     * @throws VariableAlreadySetException
     * @throws VariableNotExistsException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $variables = [];
        foreach ($scope->var()->get('simple_generator') as $key => $value) {
            $variables[$key] = $value * $this->multiplier;
        }

        $scope->var()->set(
            'simple_generator',
            $variables
        );

        return $scope;
    }
}
