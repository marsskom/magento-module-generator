<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Marsskom\Generator\Api\Data\CloneableInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
use Marsskom\Generator\Model\Scope\Variable\Collection;
use Marsskom\Generator\Model\Variable\Variable;
use function array_merge;

class ScopeVariable implements ScopeVariableInterface, CloneableInterface
{
    private Collection $collection;

    /**
     * Scope variables constructor.
     *
     * @param Collection $collection
     */
    public function __construct(
        Collection $collection
    ) {
        $this->collection = $collection;
    }

    /**
     * @inheritdoc
     */
    public function set(string $name, $value): ScopeVariableInterface
    {
        $variable = $this->collection->find($name);

        if (!$variable->isRewritable() && null !== $variable->getValue()) {
            throw new VariableAlreadySetException(__("Variable '%1' already was set", $name));
        }

        $this->collection->replace($name, new Variable(
            $variable->getName(),
            $variable->getOptions(),
            $value
        ));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function add(string $name, $value): ScopeVariableInterface
    {
        $variable = $this->collection->find($name);

        if ($variable->isSimple()) {
            throw new VariableIsNotMultipleException(__("Variable '%1' cannot has multiple values", $name));
        }

        $this->collection->replace($name, new Variable(
            $variable->getName(),
            $variable->getOptions(),
            array_merge(
                $variable->getValue() ?? [],
                [$value]
            )
        ));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function clean(string $name): ScopeVariableInterface
    {
        $variable = $this->collection->find($name);

        $this->collection->replace($name, new Variable(
            $variable->getName(),
            $variable->getOptions()
        ));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function get(string $name)
    {
        return $this->collection->find($name)->getValue();
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        $result = [];
        foreach ($this->collection->get() as $variable) {
            $result[$variable->getName()] = $variable->getValue();
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function __clone()
    {
        $this->collection = clone $this->collection;
    }
}
