<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable;

use Marsskom\Generator\Api\Data\Variable\VariableInterface;

class Variable implements VariableInterface
{
    private string $name;

    private int $options;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Variable constructor.
     *
     * @param string $name
     * @param int    $options
     * @param mixed  $value
     */
    public function __construct(
        string $name,
        int $options = VariableInterface::DEFAULT,
        $value = null
    ) {
        $this->name = $name;
        $this->options = $options;
        $this->value = $value;
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
    public function getOptions(): int
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @inheritdoc
     */
    public function isSimple(): bool
    {
        return VariableInterface::IS_SIMPLE === (VariableInterface::IS_SIMPLE & $this->options);
    }

    /**
     * @inheritdoc
     */
    public function isRewritable(): bool
    {
        return VariableInterface::IS_REWRITABLE === (VariableInterface::IS_REWRITABLE & $this->options);
    }
}
