<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Input;

use Marsskom\Generator\Api\Data\Context\Input\ModuleInterface;

class Module implements ModuleInterface
{
    private string $name;

    private string $path;

    /**
     * Module constructor.
     *
     * @param string $name
     * @param string $path
     */
    public function __construct(
        string $name,
        string $path
    ) {
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getPathToModule(): string
    {
        return $this->path;
    }
}
