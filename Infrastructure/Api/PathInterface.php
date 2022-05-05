<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Api;

use Marsskom\Generator\Magento\Model\Helper\Module;

interface PathInterface
{
    /**
     * Returns path to module.
     *
     * @param Module $module
     *
     * @return string
     */
    public function module(Module $module): string;

    /**
     * Returns path that according to module.
     *
     * @param Module $module
     * @param string $path
     *
     * @return string
     */
    public function path(Module $module, string $path): string;
}
