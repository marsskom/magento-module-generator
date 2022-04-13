<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

use Marsskom\Generator\Api\Data\Context\Input\ClassInterface;
use Marsskom\Generator\Api\Data\Context\Input\FileInterface;
use Marsskom\Generator\Api\Data\Context\Input\ModuleInterface;
use Marsskom\Generator\Api\Data\Context\Input\PathInterface;

interface InputInterface
{
    /**
     * Returns path context.
     *
     * @return PathInterface
     */
    public function path(): PathInterface;
    
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
     * @return ClassInterface
     */
    public function classCxt(): ClassInterface;
}
