<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Api\Data;

interface TemplateInterface
{
    /**
     * Converts class to string.
     *
     * @return mixed
     */
    public function __toString(): string;
}
