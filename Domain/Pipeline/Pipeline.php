<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Pipeline;

use Marsskom\Generator\Domain\Interfaces\Callables\PipelineInterface;
use function is_array;

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
            $arguments = is_array($args) ? $args : [$args];
            $args = $callable(...$arguments);
        }

        return $args;
    }
}
