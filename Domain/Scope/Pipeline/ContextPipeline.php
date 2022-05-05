<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Pipeline;

use Marsskom\Generator\Domain\Exception\Context\ContextNotFoundException;
use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;
use Marsskom\Generator\Domain\Pipeline\Pipeline;

class ContextPipeline extends Pipeline
{
    private string $contextAlias;

    /**
     * @inheritdoc
     *
     * @param string $contextAlias
     */
    public function __construct(
        string $contextAlias,
        array $callables
    ) {
        parent::__construct($callables);

        $this->contextAlias = $contextAlias;
    }

    /**
     * @inheritdoc
     *
     * @throws ContextNotFoundException
     */
    public function __invoke(...$args)
    {
        foreach ($args as $key => $arg) {
            if ($arg instanceof ScopeInterface) {
                $args[$key] = $arg->setActiveContextAlias($this->contextAlias);
                break;
            }
        }

        return parent::__invoke(...$args);
    }
}
