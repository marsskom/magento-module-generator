<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Interfaces\Repository\ContextRepositoryInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;

class ScopeBuilder
{
    /**
     * Builds scope.
     *
     * @param ContextRepositoryInterface $repository
     * @param InputInterface             $input
     *
     * @return ScopeInterface
     */
    public function build(ContextRepositoryInterface $repository, InputInterface $input): ScopeInterface
    {
        return new Scope($repository, $input);
    }
}
