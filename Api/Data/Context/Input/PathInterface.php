<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context\Input;

interface PathInterface
{
    /**
     * Returns path to module.
     *
     * @return string
     */
    public function toModule(): string;

    /**
     * Returns path to file.
     *
     * @return string
     */
    public function toFile(): string;
}
