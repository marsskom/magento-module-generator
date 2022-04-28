<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces;

interface ContextInterface
{
    /**
     * Sets variable.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return ContextInterface
     */
    public function set(string $name, $value): ContextInterface;

    /**
     * Adds value to variable.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return ContextInterface
     */
    public function add(string $name, $value): ContextInterface;

    /**
     * Unsets variable's value.
     *
     * @param string $name
     *
     * @return ContextInterface
     */
    public function unset(string $name): ContextInterface;

    /**
     * Returns variable value.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name);

    /**
     * Returns variable existence state.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Returns variables as array.
     *
     * @return array<string, mixed>
     */
    public function getAll(): array;
}
