<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Callables;

use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Magento\Exception\PropertyStringIsInvalidException;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Input\Property;
use Marsskom\Generator\Magento\Model\Parser\PropertiesParser;

class MethodCallable
{
    /**
     * Invoke method.
     *
     * @param ContextInterface $c
     * @param InputInterface   $i
     *
     * @return ContextInterface
     *
     * @throws VariableNotExistsException
     * @throws InputNotExistsException
     * @throws PropertyStringIsInvalidException
     */
    public function __invoke(ContextInterface $c, InputInterface $i): ContextInterface
    {
        $propsObjects = (new PropertiesParser())->parse($i->get(InputParameter::PROPERTIES));

        $methods = [];
        $methods[] = $this->createConstructor($c, $propsObjects);

        foreach ($propsObjects as $property) {
            $methods[] = $this->createSetter($c, $property);
            $methods[] = $this->createGetter($c, $property);
        }

        return $c->set(
            TemplateVariable::METHODS,
            // `array_values` is required here for reindex the keys
            // 'cause it is important for mustache template engine.
            array_values(array_filter($methods))
        );
    }

    /**
     * Creates constructor method.
     *
     * @param ContextInterface $context
     * @param array            $properties
     *
     * @return array
     *
     * @throws VariableNotExistsException
     */
    protected function createConstructor(ContextInterface $context, array $properties): array
    {
        if ($context->has(TemplateVariable::INTERFACE_NAME)) {
            return [];
        }

        $props = array_filter($properties, static function (Property $property) {
            return $property->useInConstructor();
        });
        if (empty($props)) {
            return [];
        }

        $className = $context->get(TemplateVariable::CLASS_NAME);
        $annotation = <<<TEXT
/**
     * $className constructor.
     *
TEXT;
        $parameters = [];
        $bodyLines = [];

        foreach ($props as $property) {
            $name = $property->getName();
            $parameter = implode('|', $property->getTypes()) . ' $' . $name;

            $parameters[] = $parameter;
            $annotation .= "\n     * @param " . $parameter;
            $bodyLines[] = (!empty($bodyLines) ? '        ' : '')
                . "\$this->" . $name . ' = $' . $name . ';';
        }

        $annotation .= "\n     */";

        return [
            'annotation' => $annotation,
            'name'       => '__construct',
            'parameters' => implode(', ', $parameters),
            'body'       => implode("\n", $bodyLines),
        ];
    }

    /**
     * Creates set method.
     *
     * @param ContextInterface $context
     * @param Property         $property
     *
     * @return array
     *
     * @throws VariableNotExistsException
     */
    protected function createSetter(ContextInterface $context, Property $property): array
    {
        if (!$property->hasSetter()) {
            return [];
        }

        $name = $property->getName();
        $types = implode('|', $property->getTypes());

        if ($context->has(TemplateVariable::INTERFACE_NAME)) {
            $returnType = $context->get(TemplateVariable::INTERFACE_NAME);
        } else {
            $implements = $context->has(TemplateVariable::CLASS_IMPLEMENTS) ?
                $context->get(TemplateVariable::CLASS_IMPLEMENTS)
                : [];
            $implements = $implements ? array_shift($implements) : null;
            $returnType = $implements ?? $context->get(TemplateVariable::CLASS_NAME);
        }

        $annotation = <<<TEXT
/**
     * Sets $name value.
     *
     * @param $types \$$name
     *
     * @return $returnType
     */
TEXT;

        if (!$context->has(TemplateVariable::INTERFACE_NAME)
            && $context->has(TemplateVariable::CLASS_IMPLEMENTS)) {
            $annotation = <<<TEXT
/**
     * @inheritdoc
     */
TEXT;
        }

        return [
            'annotation'  => $annotation,
            'name'        => 'set' . ucfirst($name),
            'parameters'  => $types . ' $' . $name,
            'return_type' => $returnType,
            'body'        => <<<PHP
\$this->$name = \$$name;

        return \$this;
PHP,
        ];
    }

    /**
     * Creates get method.
     *
     * @param ContextInterface $context
     * @param Property         $property
     *
     * @return array
     */
    protected function createGetter(ContextInterface $context, Property $property): array
    {
        if (!$property->hasGetter()) {
            return [];
        }

        $types = implode('|', $property->getTypes());
        $annotation = <<<TEXT
/**
     * Returns {$property->getName()} value.
     *
     * @return $types
     */
TEXT;

        if (!$context->has(TemplateVariable::INTERFACE_NAME)
            && $context->has(TemplateVariable::CLASS_IMPLEMENTS)) {
            $annotation = <<<TEXT
/**
     * @inheritdoc
     */
TEXT;
        }

        return [
            'annotation'  => $annotation,
            'name'        => 'get' . ucfirst($property->getName()),
            'parameters'  => '',
            'return_type' => $types,
            'body'        => 'return $this->' . $property->getName() . ';',
        ];
    }
}
