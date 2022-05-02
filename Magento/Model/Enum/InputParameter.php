<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Enum;

// phpcs:disable Magento2.PHP.FinalImplementation
final class InputParameter
{
    /**
     * Module name.
     */
    public const MODULE = 'module';

    /**
     * File location.
     */
    public const PATH = 'path';

    /**
     * Filename or/and classname.
     */
    public const NAME = 'name';

    /**
     * Class properties.
     */
    public const PROPERTIES = 'props';
}
