<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Pipeline;

use Marsskom\Generator\Domain\Interfaces\Callables\PipelineInterface;

class Pipeline implements PipelineInterface
{
    /**
     * @var callable[]
     */
    private array $callables;

    /**
     * Pipeline constructor.
     *
     * @param array $callables
     */
    public function __construct(array $callables)
    {
        $this->callables = $callables;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(...$args)
    {
        foreach ($this->callables as $callable) {
            $callable(...$args);
        }
    }
}
