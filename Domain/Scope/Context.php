<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Interfaces\CloneableInterface;
use Marsskom\Generator\Domain\Interfaces\Context\ContextIdInterface;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Context\VariableInterface;
use Marsskom\Generator\Domain\Scope\Context\Variable;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_merge;
use function is_array;
use function sprintf;

class Context implements ContextInterface, CloneableInterface
{
    private ContextIdInterface $identity;

    /**
     * @var array<string, VariableInterface>
     */
    private array $variables = [];

    /**
     * Context constructor.
     *
     * @param ContextIdInterface $id
     */
    public function __construct(ContextIdInterface $id)
    {
        $this->identity = $id;
    }

    /**
     * @inheritdoc
     */
    public function id(): ContextIdInterface
    {
        return $this->identity;
    }

    /**
     * @inheritdoc
     */
    public function set(string $name, $value): ContextInterface
    {
        $new = clone $this;
        $new->variables[$name] = new Variable(
            $name,
            $value
        );

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function add(string $name, $value): ContextInterface
    {
        $currentValue = $this->has($name) ? $this->get($name) : null;
        if (null === $currentValue) {
            return $this->set($name, is_array($value) ? $value : [$value]);
        }

        $new = clone $this;
        $new->variables[$name] = new Variable(
            $name,
            array_merge(
                is_array($currentValue) ? $currentValue : [$currentValue],
                is_array($value) ? $value : [$value],
            )
        );

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function unset(string $name): ContextInterface
    {
        if (!$this->has($name)) {
            throw new VariableNotExistsException(
                sprintf("Variable '%s' not exists", $name)
            );
        }

        $new = clone $this;
        unset($new->variables[$name]);

        return $new;
    }

    /**
     * @inheritdoc
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            throw new VariableNotExistsException(
                sprintf("Variable '%s' not exists", $name)
            );
        }

        return $this->variables[$name]->value();
    }

    /**
     * @inheritdoc
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->variables);
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        $result = [];
        foreach ($this->variables as $name => $variable) {
            // TODO: convert variable's value into string if need.
            $result[$name] = $variable->value();
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function __clone()
    {
        $this->variables = array_merge(
            ...array_map(
                static fn(string $k, VariableInterface $v) => [$k => clone $v],
                array_keys($this->variables),
                $this->variables
            )
        );
    }
}
