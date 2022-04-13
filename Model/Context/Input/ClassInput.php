<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Input;

use Marsskom\Generator\Api\Data\Context\Input\ClassInterface;

class ClassInput implements ClassInterface
{
    private string $name;

    private string $extends;

    private array $implements;

    private array $comments;

    /**
     * Class input constructor.
     *
     * @param string   $name
     * @param string   $extends
     * @param string[] $implements
     * @param string[] $comments
     */
    public function __construct(
        string $name,
        string $extends,
        array $implements,
        array $comments
    ) {
        $this->name = $name;
        $this->extends = $extends;
        $this->implements = $implements;
        $this->comments = $comments;
    }

    /**
     * @inheritdoc
     */
    public function getClassName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function hasExtends(): bool
    {
        return !empty($this->extends);
    }

    /**
     * @inheritdoc
     */
    public function getExtends(): string
    {
        return $this->extends;
    }

    /**
     * @inheritdoc
     */
    public function hasImplements(): bool
    {
        return !empty($this->implements);
    }

    /**
     * @inheritdoc
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    /**
     * @inheritdoc
     */
    public function hasComments(): bool
    {
        return !empty($this->comments);
    }

    /**
     * @inheritdoc
     */
    public function getComments(): array
    {
        return $this->comments;
    }
}
