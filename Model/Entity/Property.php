<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Entity;

class Property
{
    private string $name;

    /**
     * @var string[]
     */
    private array $types;

    private bool $hasSetter;

    private bool $hasGetter;

    /**
     * Property constructor.
     *
     * @param string   $name
     * @param string[] $types
     * @param bool     $hasSetter
     * @param bool     $hasGetter
     */
    public function __construct(
        string $name,
        array $types,
        bool $hasSetter,
        bool $hasGetter
    ) {
        $this->name = $name;
        $this->types = $types;
        $this->hasSetter = $hasSetter;
        $this->hasGetter = $hasGetter;
    }

    /**
     * Returns property name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns property types.
     *
     * @return string[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * Returns "has setter" state.
     *
     * @return bool
     */
    public function hasSetter(): bool
    {
        return $this->hasSetter;
    }

    /**
     * Returns "has getter" state.
     *
     * @return bool
     */
    public function hasGetter(): bool
    {
        return $this->hasGetter;
    }
}
