<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Enum;

// phpcs:disable Magento2.PHP.FinalImplementation
final class InputParameter
{
    /**
     * Module name.
     */
    public const MODULE = 'module';

    /**
     * Filename or/and classname.
     */
    public const NAME = 'name';

    /**
     * File location.
     */
    public const PATH = 'path';
}
