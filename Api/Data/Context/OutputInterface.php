<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

interface OutputInterface
{
    /**
     * Sets context state.
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
     * Returns output as string.
     *
     * @return string
     */
    public function asString(): string;
}
