<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Infrastructure\Mock;

use Marsskom\Generator\Domain\Interfaces\Callables\CallableInterface;

class ValueCallable implements CallableInterface
{
    private $value;

    /**
     * Value callable constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(...$args)
    {
        return $this->value;
    }
}
