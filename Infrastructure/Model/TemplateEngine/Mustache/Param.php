<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache;

class Param
{
    private string $stubName;

    private array $variables;

    /**
     * Param constructor.
     *
     * @param string $stubName
     * @param array  $variables
     */
    public function __construct(string $stubName, array $variables)
    {
        $this->stubName = $stubName;
        $this->variables = $variables;
    }

    /**
     * Returns stub name.
     *
     * @return string
     */
    public function stubName(): string
    {
        return $this->stubName;
    }

    /**
     * Returns variables.
     *
     * @return array
     */
    public function variables(): array
    {
        return $this->variables;
    }
}
