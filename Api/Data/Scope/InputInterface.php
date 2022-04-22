<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Scope;

interface InputInterface
{
    /**
     * Returns input existence.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Returns input value.
     *
     * @param string $key
     *
     * @return null|mixed
     */
    public function get(string $key);

    /**
     * Returns input values.
     *
     * @return array
     */
    public function getAll(): array;
}
