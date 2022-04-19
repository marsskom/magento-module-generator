<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper\Builder;

use Marsskom\Generator\Model\Helper\Module;
use function explode;

class ModuleBuilder
{
    /**
     * Creates module from Magneto 2 module name.
     *
     * @param string $moduleName
     *
     * @return Module
     */
    public function fromMagentoModuleName(string $moduleName): Module
    {
        $chunks = explode('_', $moduleName);

        return new Module($chunks[0], $chunks[1]);
    }
}
