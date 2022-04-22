<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Sequence;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class SimpleGenerator extends AbstractSequence
{
    private string $value;

    /**
     * @inheritdoc
     *
     * @param string $value
     */
    public function __construct(
        string $value,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->value = $value;
    }

    /**
     * @inheritdoc
     *
     * @throws VariableIsNotMultipleException
     * @throws VariableNotExistsException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $scope->var()->add(
            'simple_generator',
            $this->value
        );

        return $scope;
    }
}
