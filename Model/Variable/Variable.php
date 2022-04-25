<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Variable;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Api\Data\Variable\VariableInterface;
use function call_user_func;

class Variable implements VariableInterface, TemplateInterface
{
    private string $name;

    private int $options;

    /**
     * Callback for `call_user_func`
     *
     * @var null|callable|mixed
     */
    private $stringRepresentationClosure;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Variable constructor.
     *
     * @param string              $name
     * @param int                 $options
     * @param null|callback|mixed $stringRepresentationClosure - `call_user_func` callback
     * @param mixed               $value
     */
    public function __construct(
        string $name,
        int $options = VariableInterface::DEFAULT,
        $stringRepresentationClosure = null,
        $value = null
    ) {
        $this->name = $name;
        $this->options = $options;
        $this->stringRepresentationClosure = $stringRepresentationClosure;
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

    /**
     * @inheritdoc
     */
    public function getStringRepresentation()
    {
        return $this->stringRepresentationClosure;
    }

    /**
     * @inheritdoc
     */
    public function hasStringRepresentation(): bool
    {
        return null !== $this->stringRepresentationClosure;
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        if (!$this->hasStringRepresentation()) {
            return (string) $this->value;
        }

        return call_user_func($this->stringRepresentationClosure, $this->value);
    }
}
