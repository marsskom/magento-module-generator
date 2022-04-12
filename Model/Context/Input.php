<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\Input\ClassInterface;
use Marsskom\Generator\Api\Data\Context\Input\FileInterface;
use Marsskom\Generator\Api\Data\Context\Input\ModuleInterface;
use Marsskom\Generator\Api\Data\Context\InputInterface;

class Input implements InputInterface
{
    private ModuleInterface $module;

    private FileInterface $file;

    private ClassInterface $class;

    /**
     * Input context constructor.
     *
     * @param ModuleInterface $module
     * @param FileInterface   $file
     * @param ClassInterface  $class
     */
    public function __construct(
        ModuleInterface $module,
        FileInterface $file,
        ClassInterface $class
    ) {
        $this->module = $module;
        $this->file = $file;
        $this->class = $class;
    }

    /**
     * @inheritdoc
     */
    public function module(): ModuleInterface
    {
        return $this->module;
    }

    /**
     * @inheritdoc
     */
    public function file(): FileInterface
    {
        return $this->file;
    }

    /**
     * @inheritdoc
     */
    public function iclass(): ClassInterface
    {
        return $this->class;
    }
}
