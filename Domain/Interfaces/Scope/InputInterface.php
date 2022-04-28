<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Scope;

use Marsskom\Generator\Domain\Exception\Context\InputNotExistsException;

interface InputInterface
{
    /**
     * Returns input value.
     *
     * @param string $name
     *
     * @return string
     *
     * @throws InputNotExistsException
     */
    public function get(string $name): string;

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
     * @return array<string, string>
     */
    public function getAll(): array;
}
