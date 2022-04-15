<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\TemplateEngine\Mustache;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;

class Template implements TemplateInterface
{
    private string $content;

    /**
     * Template constructor.
     *
     * @param string $content
     */
    public function __construct(
        string $content = ''
    ) {
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
