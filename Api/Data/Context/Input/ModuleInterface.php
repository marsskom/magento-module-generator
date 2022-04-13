<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context\Input;

interface ModuleInterface
{
    /**
     * Returns module name.
     *
     * @return string
     */
    public function getModuleName(): string;
}
