<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;
use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Scope\Variable\Registry;
use Marsskom\Generator\Model\Variable\Variable;
use function array_merge;

class ScopeVariable implements ScopeVariableInterface
{
    private Registry $registry;

    /**
     * @var VariableInterface[]
     */
    private array $variables = [];

    /**
     * Scope variables constructor.
     *
     * @param Registry $registry
     */
    public function __construct(
        Registry $registry
    ) {
        $this->registry = $registry;

        $this->initVariables();
    }

    /**
     * Initializes variables according to registry.
     *
     * @return void
     */
    private function initVariables(): void
    {
        foreach ($this->registry->getAll() as $varRegistry) {
            $varName = $varRegistry->getName();

            $this->variables[$varName] = new Variable(
                $varName,
                $varRegistry->getOptions()
            );
        }
    }

    /**
     * @inheritdoc
     */
    public function set(string $name, $value): ScopeVariableInterface
    {
        if (!$this->registry->has($name)) {
            throw new VariableNotExistsException(__("Variable '%1' not exists", $name));
        }

        $variable = $this->variables[$name];

        if (!$variable->isRewritable() && null !== $variable->getValue()) {
            throw new VariableAlreadySetException(__("Variable '%1' already was set", $name));
        }

        $this->variables[$name] = new Variable(
            $variable->getName(),
            $variable->getOptions(),
            $value
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function add(string $name, $value): ScopeVariableInterface
    {
        if (!$this->registry->has($name)) {
            throw new VariableNotExistsException(__("Variable '%1' not exists", $name));
        }

        $variable = $this->variables[$name];

        if ($variable->isSimple()) {
            throw new VariableIsNotMultipleException(__("Variable '%1' cannot has multiple values", $name));
        }

        $this->variables[$name] = new Variable(
            $variable->getName(),
            $variable->getOptions(),
            array_merge(
                $variable->getValue() ?? [],
                [$value]
            )
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function clean(string $name): ScopeVariableInterface
    {
        if (!$this->registry->has($name)) {
            throw new VariableNotExistsException(__("Variable '%1' not exists", $name));
        }

        $variable = $this->variables[$name];

        $this->variables[$name] = new Variable(
            $variable->getName(),
            $variable->getOptions()
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function get(string $name)
    {
        if (!$this->registry->has($name)) {
            throw new VariableNotExistsException(__("Variable '%1' not exists", $name));
        }

        return $this->variables[$name]->getValue();
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        $variables = [];
        foreach ($this->variables as $var) {
            // TODO: maybe it needs to be converted into string
            // and don't forget about array to string conversion.
            $variables[$var->getName()] = $var->getValue();
        }

        return $variables;
    }
}
