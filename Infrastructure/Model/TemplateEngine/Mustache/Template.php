<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache;

use Marsskom\Generator\Infrastructure\Api\Data\TemplateInterface;

class Template implements TemplateInterface
{
    private string $content;

    /**
     * Template constructor.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->content;
    }
}
