<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Marsskom\Generator\Api\Data\CloneableInterface;
use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Scope\InputInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;
use Marsskom\Generator\Model\Helper\Context\IdHelper;

class Scope implements ScopeInterface, CloneableInterface
{
    private ContextInterface $context;

    private InputInterface $input;

    private InterruptInterface $interrupt;

    private ScopeVariableBuilder $scopeVariableBuilder;

    private IdHelper $idHelper;

    /**
     * @var ScopeVariableInterface[]
     */
    private array $variables = [];

    /**
     * Scope constructor.
     *
     * @param ContextInterface     $context
     * @param InputInterface       $input
     * @param InterruptInterface   $interrupt
     * @param ScopeVariableBuilder $scopeVariableBuilder
     * @param IdHelper             $idHelper
     */
    public function __construct(
        ContextInterface $context,
        InputInterface $input,
        InterruptInterface $interrupt,
        ScopeVariableBuilder $scopeVariableBuilder,
        IdHelper $idHelper
    ) {
        $this->context = $context;
        $this->input = $input;
        $this->interrupt = $interrupt;
        $this->scopeVariableBuilder = $scopeVariableBuilder;
        $this->idHelper = $idHelper;
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
    public function interrupt(): InterruptInterface
    {
        return $this->interrupt;
    }

    /**
     * Magic `__call` method.
     *
     * @param string|mixed $name
     * @param array|mixed  $arguments
     *
     * @return ScopeVariableInterface|void
     */
    public function __call($name, $arguments)
    {
        if ('var' === $name) {
            $contextId = $this->idHelper->getId($this->context);

            if (!isset($this->variables[$contextId])) {
                $this->variables[$contextId] = $this->scopeVariableBuilder->create();
            }

            return $this->variables[$contextId];
        }
    }

    /**
     * @inheritDoc
     */
    public function __clone()
    {
        $this->context = clone $this->context;
        $this->input = clone $this->input;
        $this->interrupt = clone $this->interrupt;

        $variables = [];
        foreach ($this->variables as $var) {
            $variables[] = clone $var;
        }
        $this->variables = $variables;
    }
}
