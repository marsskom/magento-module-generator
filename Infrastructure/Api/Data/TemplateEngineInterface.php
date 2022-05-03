<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Api\Data;

interface TemplateEngineInterface
{
    /**
     * Makes template.
     *
     * @param object $params
     *
     * @return TemplateInterface
     */
    public function make(object $params): TemplateInterface;
}
