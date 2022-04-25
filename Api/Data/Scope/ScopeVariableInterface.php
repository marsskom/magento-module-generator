<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Scope;

use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;

interface ScopeVariableInterface
{
    /**
     * Sets variable.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return ScopeVariableInterface
     *
     * @throws VariableNotExistsException
     * @throws VariableAlreadySetException
     */
    public function set(string $name, $value): ScopeVariableInterface;

    /**
     * Adds value to variable.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return ScopeVariableInterface
     *
     * @throws VariableNotExistsException
     * @throws VariableIsNotMultipleException
     */
    public function add(string $name, $value): ScopeVariableInterface;

    /**
     * Clean variable's value.
     *
     * @param string $name
     *
     * @return ScopeVariableInterface
     *
     * @throws VariableNotExistsException
     */
    public function clean(string $name): ScopeVariableInterface;

    /**
     * Returns variable value.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws VariableNotExistsException
     */
    public function get(string $name);

    /**
     * Returns true if variable exists and its value is not null.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Returns variables as array.
     *
     * @return array<string, string>
     */
    public function getAll(): array;
}
