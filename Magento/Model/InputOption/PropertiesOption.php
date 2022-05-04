<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\InputOption;

use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Symfony\Component\Console\Input\InputOption;

class PropertiesOption extends InputOption
{
    /**
     * Creates input option.
     *
     * @return PropertiesOption
     *
     * phpcs:disable Magento2.Functions.StaticFunction
     */
    public static function create(): PropertiesOption
    {
        return new PropertiesOption(
            InputParameter::PROPERTIES,
            null,
            InputOption::VALUE_OPTIONAL,
            <<<TEXT
            Example value: "id:int|null:sgc;name:NameInterface:g"
            ---
            What that means:
            %property_name%
            : - delimiter
            %type%
            | - type delimiter
            %another_type% - optional
            : - delimiter
            sgc - c - is an usage in constructor; s is setter; g - getter; all are optional
            ; - delimiter between properties
            ... etc, goto: %property_name% ...
            ---
            It converts into two properties `id` and `name`.
            `id` with type **int** or **null** and `name` - **NameInterface**
            Also for `id` parameter getter and setter will be created. Moreover `id` will use in `__construct`.
            For `name` - only getter. If you need only setter, set `s` after property type.
            TEXT
        );
    }
}
