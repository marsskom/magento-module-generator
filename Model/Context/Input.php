<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\InputInterface;
use Marsskom\Generator\Api\Data\StubInterface;

class Input implements InputInterface
{
    private string $stubName;

    /**
     * @var array
     */
    private array $variables = [];

    /**
     * Input constructor.
     *
     * @param string $stubName
     * @param array  $variables
     */
    public function __construct(
        string $stubName,
        array $variables = []
    ) {
        $this->stubName = $stubName;
        $this->variables = $variables;
    }

    /**
     * @inheritdoc
     */
    public function getStubName(): string
    {
        return $this->stubName;
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->variables;
    }
}
