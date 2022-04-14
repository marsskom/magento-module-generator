<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\InputInterface;
use Marsskom\Generator\Api\Data\StubInterface;

class Input implements InputInterface
{
    private string $stubName;

    /**
     * @var StubInterface[]
     */
    private array $stubClasses = [];

    /**
     * Input constructor.
     *
     * @param string $stubName
     * @param array  $stubClasses
     */
    public function __construct(
        string $stubName,
        array $stubClasses = []
    ) {
        $this->stubName = $stubName;
        $this->stubClasses = $stubClasses;
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
        $result = [];

        foreach ($this->stubClasses as $stub) {
            $result[$stub->getKey()] = $stub->toArray();
        }

        return $result;
    }
}
