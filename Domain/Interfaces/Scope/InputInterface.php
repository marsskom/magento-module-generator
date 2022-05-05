<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Scope;

use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;

interface InputInterface
{
    /**
     * Returns input value.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws InputNotExistsException
     */
    public function get(string $name);

    /**
     * Returns input variable existence state.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Returns all input.
     *
     * @return array<string, mixed>
     */
    public function getAll(): array;
}
