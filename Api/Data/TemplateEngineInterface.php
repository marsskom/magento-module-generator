<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;

interface TemplateEngineInterface
{
    /**
     * Makes template from content.
     *
     * @param string $stubName
     * @param array  $contextArray
     *
     * @return TemplateInterface
     */
    public function make(string $stubName, array $contextArray): TemplateInterface;
}
