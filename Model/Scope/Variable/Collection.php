<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableCollectionInterface;
use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use function array_merge;

class Collection
{
    /**
     * @var VariableInterface[]
     */
    private array $variables;

    /**
     * Collection constructor.
     *
     * @param VariableCollectionInterface[] $variablesCollections
     */
    public function __construct(
        array $variablesCollections
    ) {
        $variables = [];
        foreach ($variablesCollections as $collection) {
            $variables[] = $collection->variables();
        }

        $this->variables = array_merge(...$variables);
    }

    /**
     * Finds variable by name.
     *
     * @param string $name
     *
     * @return VariableInterface
     *
     * @throws VariableNotExistsException
     */
    public function find(string $name): VariableInterface
    {
        foreach ($this->variables as $variable) {
            if ($name === $variable->getName()) {
                return $variable;
            }
        }

        throw new VariableNotExistsException(__("Variable '%1' not found", $name));
    }

    /**
     * Returns true if variable exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        try {
            $this->find($name);
        } catch (VariableNotExistsException $exception) {
            return false;
        }

        return true;
    }

    /**
     * Replaces variable with new.
     *
     * @param string            $name
     * @param VariableInterface $variable
     *
     * @return $this
     *
     * @throws VariableNotExistsException
     */
    public function replace(string $name, VariableInterface $variable): Collection
    {
        foreach ($this->variables as $key => $var) {
            if ($name !== $var->getName()) {
                continue;
            }

            $this->variables[$key] = $variable;

            return $this;
        }

        throw new VariableNotExistsException(__("Variable '%1' not found", $name));
    }

    /**
     * Returns variables list.
     *
     * @return VariableInterface[]
     */
    public function get(): array
    {
        return $this->variables;
    }
}
