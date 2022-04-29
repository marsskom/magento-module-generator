<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Callables;

use Marsskom\Generator\Domain\Exception\Callables\IsNotCallableException;

interface CallableBuilderInterface
{
    /**
     * Builds callbacks pipelines.
     *
     * @param array $callables
     *
     * @return array
     *
     * @throws IsNotCallableException
     */
    public function build(array $callables): array;
}
