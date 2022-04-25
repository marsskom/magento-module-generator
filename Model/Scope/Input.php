<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Marsskom\Generator\Api\Data\Scope\InputInterface;

class Input implements InputInterface
{
    private array $userInput;

    /**
     * Input constructor.
     *
     * @param array $userInput
     */
    public function __construct(
        array $userInput
    ) {
        $this->userInput = $userInput;
    }

    /**
     * @inheritdoc
     */
    public function has(string $key): bool
    {
        return isset($this->userInput[$key]);
    }

    /**
     * @inheritdoc
     */
    public function get(string $key)
    {
        return $this->userInput[$key] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        return $this->userInput;
    }
}
