<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Helper\Builder;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Magento\Model\Helper\Module;

class ModuleBuilder
{
    /**
     * Creates module from Magneto 2 module name.
     *
     * @param string $moduleName
     *
     * @return Module
     *
     * @throws LocalizedException
     */
    public function fromMagentoModuleName(string $moduleName): Module
    {
        $chunks = explode('_', $moduleName);
        if (count($chunks) !== 2) {
            throw new LocalizedException(__("Module name is incorrect."));
        }

        return new Module($chunks[0], $chunks[1]);
    }
}
