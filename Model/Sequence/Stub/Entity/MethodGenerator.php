<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Entity\PropertyStringIsInvalid;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Entity\Property;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\InputParser\Entity\PropertiesParser;
use function array_filter;
use function array_shift;
use function array_values;
use function implode;
use function ucfirst;

class MethodGenerator extends AbstractSequence
{
    private PropertiesParser $parser;

    /**
     * @inheritdoc
     *
     * @param PropertiesParser $parser
     */
    public function __construct(
        PropertiesParser $parser,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->parser = $parser;
    }

    /**
     * @inheritdoc
     *
     * @throws PropertyStringIsInvalid
     * @throws VariableAlreadySetException
     * @throws VariableNotExistsException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $propsObjects = $this->parser->parse(
            $scope->input()->get(InputParameter::PROPERTIES) ?? ''
        );

        $methods = [];

        $methods[] = $this->createConstructor($scope, $propsObjects);

        foreach ($propsObjects as $property) {
            $methods[] = $this->createSetter($scope, $property);
            $methods[] = $this->createGetter($scope, $property);
        }

        $scope->var()->set(
            TemplateVariable::METHODS,
            // `array_values` is required here for reindex the keys that is important for mustache template engine.
            array_values(array_filter($methods))
        );

        return $scope;
    }

    /**
     * Creates constructor method.
     *
     * @param ScopeInterface $scope
     * @param Property[]     $properties
     *
     * @return array
     *
     * @throws VariableNotExistsException
     */
    protected function createConstructor(ScopeInterface $scope, array $properties): array
    {
        if ($scope->var()->has(TemplateVariable::INTERFACE_NAME)) {
            return [];
        }

        $props = array_filter($properties, static function (Property $property) {
            return $property->useInConstructor();
        });
        if (empty($props)) {
            return [];
        }

        $className = $scope->var()->get(TemplateVariable::CLASS_NAME);
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
     * @param ScopeInterface $scope
     * @param Property       $property
     *
     * @return array
     *
     * @throws VariableNotExistsException
     */
    protected function createSetter(ScopeInterface $scope, Property $property): array
    {
        if (!$property->hasSetter()) {
            return [];
        }

        $name = $property->getName();
        $types = implode('|', $property->getTypes());

        $returnType = $scope->var()->get(TemplateVariable::INTERFACE_NAME);
        if (empty($returnType)) {
            $implements = $scope->var()->get(TemplateVariable::CLASS_IMPLEMENTS);
            $implements = $implements ? array_shift($implements) : null;
            $returnType = $implements ?? $scope->var()->get(TemplateVariable::CLASS_NAME);
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

        if (!$scope->var()->has(TemplateVariable::INTERFACE_NAME)
            && $scope->var()->has(TemplateVariable::CLASS_IMPLEMENTS)) {
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
     * @param ScopeInterface $scope
     * @param Property       $property
     *
     * @return array
     */
    protected function createGetter(ScopeInterface $scope, Property $property): array
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

        if (!$scope->var()->has(TemplateVariable::INTERFACE_NAME)
            && $scope->var()->has(TemplateVariable::CLASS_IMPLEMENTS)) {
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
