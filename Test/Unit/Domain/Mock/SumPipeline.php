<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Mock;

use Marsskom\Generator\Domain\Interfaces\Callables\PipelineInterface;

class SumPipeline implements PipelineInterface
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
        $sum = 0;

        foreach ($this->callables as $callable) {
            $sum += $callable(...$args);
        }

        return $sum;
    }
}
