<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Pipeline;

use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Domain\Exception\Pipeline\ConditionFailedException;

class ConditionPipeline extends Pipeline
{
    /**
     * @var callable
     */
    private $conditionCallable;

    /**
     * Condition pipeline constructor.
     *
     * @param callable $conditionCallable
     * @param array    $callables
     */
    public function __construct(
        callable $conditionCallable,
        array $callables
    ) {
        parent::__construct($callables);

        $this->conditionCallable = $conditionCallable;
    }

    /**
     * @inheritdoc
     *
     * @throws EventNameNotExistsException
     */
    public function __invoke(...$args)
    {
        try {
            ($this->conditionCallable)(...$args);
        } catch (ConditionFailedException $exception) {
            return $args;
        }

        return parent::__invoke(...$args);
    }
}
