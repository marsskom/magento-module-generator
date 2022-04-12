<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

interface OutputInterface
{
    /**
     * Sets  context state.
     *
     * @param mixed $value
     *
     * @return OutputInterface
     */
    public function setState($value): OutputInterface;

    /**
     * Returns state.
     *
     * @return mixed
     */
    public function getState();

    /**
     * Returns result.
     *
     * @return string
     */
    public function getResult(): string;
}
