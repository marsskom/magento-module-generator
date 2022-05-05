<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Helper;

use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;

class ArgFindHelper
{
    /**
     * Returns scope.
     *
     * @param array $args
     *
     * @return null|ScopeInterface
     */
    public function scope(array $args): ?ScopeInterface
    {
        return $this->byClass($args, ScopeInterface::class);
    }

    /**
     * Returns context.
     *
     * @param array $args
     *
     * @return null|ContextInterface
     */
    public function context(array $args): ?ContextInterface
    {
        return $this->byClass($args, ContextInterface::class);
    }

    /**
     * Returns input.
     *
     * @param array $args
     *
     * @return null|InputInterface
     */
    public function input(array $args): ?InputInterface
    {
        return $this->byClass($args, InputInterface::class);
    }

    /**
     * Returns argument by class instance.
     *
     * @param array  $args
     * @param string $className
     *
     * @return null|mixed
     */
    protected function byClass(array $args, string $className)
    {
        foreach ($args as $arg) {
            if ($arg instanceof $className) {
                return $arg;
            }
        }

        return null;
    }
}
