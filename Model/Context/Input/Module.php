<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Input;

use Marsskom\Generator\Api\Data\Context\Input\ModuleInterface;

class Module implements ModuleInterface
{
    private string $name;

    /**
     * Module constructor.
     *
     * @param string $name
     */
    public function __construct(
        string $name
    ) {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getModuleName(): string
    {
        return $this->name;
    }
}
