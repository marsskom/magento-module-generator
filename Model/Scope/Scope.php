<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Marsskom\Generator\Api\Data\CloneableInterface;
use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Scope\InputInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;

class Scope implements ScopeInterface, CloneableInterface
{
    private ContextInterface $context;

    private InputInterface $input;

    private ScopeVariableInterface $variable;

    private InterruptInterface $interrupt;

    /**
     * Scope constructor.
     *
     * @param ContextInterface       $context
     * @param InputInterface         $input
     * @param ScopeVariableInterface $variable
     * @param InterruptInterface     $interrupt
     */
    public function __construct(
        ContextInterface $context,
        InputInterface $input,
        ScopeVariableInterface $variable,
        InterruptInterface $interrupt
    ) {
        $this->context = $context;
        $this->input = $input;
        $this->variable = $variable;
        $this->interrupt = $interrupt;
    }

    /**
     * @inheritdoc
     */
    public function context(): ContextInterface
    {
        return $this->context;
    }

    /**
     * @inheritdoc
     */
    public function input(): InputInterface
    {
        return $this->input;
    }

    /**
     * @inheritdoc
     */
    public function var(): ScopeVariableInterface
    {
        return $this->variable;
    }

    /**
     * @inheritdoc
     */
    public function interrupt(): InterruptInterface
    {
        return $this->interrupt;
    }

    /**
     * @inheritDoc
     */
    public function __clone()
    {
        $this->context = clone $this->context;
        $this->input = clone $this->input;
        $this->variable = clone $this->variable;
        $this->interrupt = clone $this->interrupt;
    }
}
