<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableRegistryCollectionInterface;
use Marsskom\Generator\Model\Variable\VariableRegistry;
use function array_merge;

class Registry
{
    /**
     * @var VariableRegistry[]
     */
    private array $registries;

    /**
     * Collection constructor.
     *
     * @param VariableRegistryCollectionInterface[] $registriesCollections
     */
    public function __construct(
        array $registriesCollections
    ) {
        $registries = [];
        foreach ($registriesCollections as $collection) {
            $registries[] = $collection->registries();
        }

        $this->registries = array_merge(...$registries);
    }

    /**
     * Returns true if variable exists in registries.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        foreach ($this->registries as $registry) {
            if ($name === $registry->getName()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns variable by name.
     *
     * @param string $name
     *
     * @return null|VariableRegistry
     */
    public function get(string $name): ?VariableRegistry
    {
        foreach ($this->registries as $registry) {
            if ($name === $registry->getName()) {
                return $registry;
            }
        }

        return null;
    }

    /**
     * Returns all registries.
     *
     * @return VariableRegistry[]
     */
    public function getAll(): array
    {
        return $this->registries;
    }
}
