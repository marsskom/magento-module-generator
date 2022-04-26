<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Generator;
use Marsskom\Generator\Api\Data\CloneableInterface;
use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Scope\InputInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;
use Marsskom\Generator\Exception\Context\ContextAliasAlreadyExistsException;
use Marsskom\Generator\Exception\Context\ContextAlreadyRegisteredException;
use Marsskom\Generator\Exception\Context\ContextIncorrectException;
use Marsskom\Generator\Exception\Context\ContextNotFound;
use Marsskom\Generator\Model\Helper\Context\IdHelper;
use Marsskom\Generator\Model\Helper\Context\Validator;

class Scope implements ScopeInterface, CloneableInterface
{
    private ContextInterface $context;

    private InputInterface $input;

    private InterruptInterface $interrupt;

    private ScopeVariableBuilder $scopeVariableBuilder;

    private IdHelper $idHelper;

    private Validator $validator;

    /**
     * @var ScopeVariableInterface[]
     */
    private array $variables = [];

    /**
     * Context aliases as keys and ids in values.
     *
     * @var array<string, string>
     */
    private array $aliases = [];

    /**
     * Scope constructor.
     *
     * @param ContextInterface     $context
     * @param InputInterface       $input
     * @param InterruptInterface   $interrupt
     * @param ScopeVariableBuilder $scopeVariableBuilder
     * @param IdHelper             $idHelper
     * @param Validator            $validator
     */
    public function __construct(
        ContextInterface $context,
        InputInterface $input,
        InterruptInterface $interrupt,
        ScopeVariableBuilder $scopeVariableBuilder,
        IdHelper $idHelper,
        Validator $validator
    ) {
        $this->context = $context;
        $this->input = $input;
        $this->interrupt = $interrupt;
        $this->scopeVariableBuilder = $scopeVariableBuilder;
        $this->idHelper = $idHelper;
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     *
     * @throws ContextAlreadyRegisteredException
     * @throws ContextAliasAlreadyExistsException
     */
    public function registerContext(
        ContextInterface $context,
        string $alias = ScopeInterface::DEFAULT_CONTEXT
    ): ScopeInterface {
        $contextId = $this->idHelper->getId($context);

        if (isset($this->variables[$contextId])) {
            throw new ContextAlreadyRegisteredException(__("Context already registered"));
        }
        if (isset($this->aliases[$alias])) {
            throw new ContextAliasAlreadyExistsException(__("Context alias '%1' already in use", [$alias]));
        }

        $this->variables[$contextId] = $this->scopeVariableBuilder->create();
        $this->aliases[$alias] = $context;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setCurrentContext(ContextInterface $context): ScopeInterface
    {
        $this->context = $context;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @throws ContextNotFound
     */
    public function setCurrentContextFromAlias(string $alias): ScopeInterface
    {
        if (!isset($this->aliases[$alias])) {
            throw new ContextNotFound(__("Context not found by alias '%1'", [$alias]));
        }

        $this->context = $this->aliases[$alias];

        return $this;
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
     * @inheritdoc
     *
     * @throws ContextIncorrectException
     */
    public function var(): ScopeVariableInterface
    {
        $this->validator->validate($this->context);

        $contextId = $this->idHelper->getId($this->context);

        if (!isset($this->variables[$contextId])) {
            $this->variables[$contextId] = $this->scopeVariableBuilder->create();
        }

        return $this->variables[$contextId];
    }

    /**
     * @inheritdoc
     *
     * @throws ContextNotFound
     */
    public function for(string $contextAlias): ScopeVariableInterface
    {
        if (!isset($this->aliases[$contextAlias])) {
            throw new ContextNotFound(__("Context not found by alias '%1'", [$contextAlias]));
        }

        $contextId = $this->idHelper->getId($this->aliases[$contextAlias]);
        if (!isset($this->variables[$contextId])) {
            throw new ContextNotFound(__("Context not found although the alias '%1' is present", [$contextAlias]));
        }

        return $this->variables[$contextId];
    }

    /**
     * @inheritdoc
     *
     * @throws ContextNotFound
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function walk(): Generator
    {
        $clonedScope = clone $this;

        foreach ($clonedScope->aliases as $alias => $context) {
            if (ScopeInterface::DEFAULT_CONTEXT === $alias) {
                // Skips default scope that will set as last.
                continue;
            }

            $clonedScope->setCurrentContextFromAlias($alias);
            yield $clonedScope;
        }

        $clonedScope->setCurrentContextFromAlias(ScopeInterface::DEFAULT_CONTEXT);
        yield $clonedScope;
    }

    /**
     * @inheritdoc
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

        $aliases = [];
        foreach ($this->aliases as $alias => $context) {
            $aliases[$alias] = clone $context;
        }
        $this->aliases = $aliases;
    }
}
