<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\TemplateEngine;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use function implode;

class TemplateFromArray implements TemplateInterface
{
    private array $variables;

    public function __construct(
        array $variables = []
    ) {
        $this->variables = $variables;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return implode('', $this->variables);
    }
}
