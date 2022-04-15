<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Template;

interface TemplateInterface
{
    /**
     * Magic to string method.
     *
     * @return string
     */
    public function __toString(): string;
}
