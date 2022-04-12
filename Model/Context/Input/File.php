<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Input;

use Marsskom\Generator\Api\Data\Context\Input\FileInterface;
use Marsskom\Generator\Model\Helper\UseModel;
use function implode;

class File implements FileInterface
{
    private string $name;

    private string $extension;

    private string $path;

    private string $namespace;

    /**
     * @var UseModel[]
     */
    private array $uses;

    /**
     * File input constructor.
     *
     * @param string     $name
     * @param string     $extension
     * @param string     $path
     * @param string     $namespace
     * @param UseModel[] $uses
     */
    public function __construct(
        string $name,
        string $extension,
        string $path,
        string $namespace,
        array $uses = []
    ) {
        $this->name = $name;
        $this->extension = $extension;
        $this->path = $path;
        $this->namespace = $namespace;
        $this->uses = $uses;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @inheritdoc
     */
    public function getFullName(): string
    {
        return implode('.', [$this->name, $this->extension]);
    }

    /**
     * @inheritdoc
     */
    public function getPathToFile(): string
    {
        return $this->path;
    }

    /**
     * @inheritdoc
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @inheritdoc
     */
    public function hasUses(): bool
    {
        return !empty($this->uses);
    }

    /**
     * @inheritdoc
     */
    public function getUses(): array
    {
        return $this->uses;
    }
}
