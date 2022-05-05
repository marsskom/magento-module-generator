<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Input;

class Property
{
    private string $name;

    /**
     * @var string[]
     */
    private array $types;

    private bool $hasSetter;

    private bool $hasGetter;

    private bool $useInConstructor;

    /**
     * Property constructor.
     *
     * @param string   $name
     * @param string[] $types
     * @param bool     $hasSetter
     * @param bool     $hasGetter
     * @param bool     $useInConstructor
     */
    public function __construct(
        string $name,
        array $types,
        bool $hasSetter,
        bool $hasGetter,
        bool $useInConstructor
    ) {
        $this->name = $name;
        $this->types = $types;
        $this->hasSetter = $hasSetter;
        $this->hasGetter = $hasGetter;
        $this->useInConstructor = $useInConstructor;
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

    /**
     * Returns true if property is used in constructor.
     *
     * @return bool
     */
    public function useInConstructor(): bool
    {
        return $this->useInConstructor;
    }
}
