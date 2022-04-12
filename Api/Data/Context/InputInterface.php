<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

use Marsskom\Generator\Api\Data\Context\Input\ClassInterface;
use Marsskom\Generator\Api\Data\Context\Input\FileInterface;
use Marsskom\Generator\Api\Data\Context\Input\ModuleInterface;

interface InputInterface
{
    /**
     * Returns module input context.
     *
     * @return ModuleInterface
     */
    public function module(): ModuleInterface;

    /**
     * Returns file input context.
     *
     * @return FileInterface
     */
    public function file(): FileInterface;

    /**
     * Returns class input context.
     *
     * !!! WARNING
     * About strange method name `iclass`.
     * I cannot call it `class` so this is input-class -> `iclass`.
     *
     * @return ClassInterface
     */
    public function iclass(): ClassInterface;
}
