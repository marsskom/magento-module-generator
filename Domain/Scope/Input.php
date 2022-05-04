<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use function array_keys;
use function array_map;
use function sprintf;

class Input implements InputInterface
{
    /**
     * @var array<string, string>
     */
    private array $input;

    /**
     * Input constructor.
     *
     * @param array<string, string> $input
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(array $input)
    {
        array_map(static fn(string $key, $value) => null, array_keys($input), $input);

        $this->input = $input;
    }

    /**
     * @inheritdoc
     */
    public function get(string $name): string
    {
        if (!$this->has($name)) {
            throw new InputNotExistsException(
                sprintf("Input option '%s' not exists", $name)
            );
        }

        return $this->input[$name];
    }

    /**
     * @inheritdoc
     */
    public function has(string $name): bool
    {
        return isset($this->input[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getAll(): array
    {
        return $this->input;
    }
}
