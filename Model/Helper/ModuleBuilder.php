<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper;

use function explode;

class ModuleBuilder
{
    private ModuleFactory $moduleFactory;

    /**
     * Module builder constructor.
     *
     * @param ModuleFactory $moduleFactory
     */
    public function __construct(
        ModuleFactory $moduleFactory
    ) {
        $this->moduleFactory = $moduleFactory;
    }

    /**
     * Create module from cli string value.
     *
     * @param string $moduleName
     *
     * @return Module
     */
    public function fromCliString(string $moduleName): Module
    {
        $chunks = explode('_', $moduleName);

        return $this->moduleFactory->create([
            'vendor' => $chunks[0],
            'name'   => $chunks[1],
        ]);
    }
}
