<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Exception\Entity\PropertyStringIsInvalid;
use Marsskom\Generator\Model\Entity\Property;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\InputParser\Entity\PropertiesParser;
use function array_filter;
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
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $propsObjects = $this->parser->parse(
            $context->getUserInput()[InputParameter::PROPERTIES] ?? ''
        );

        $methods = [];
        foreach ($propsObjects as $property) {
            $methods[] = $this->createSetter($property);
            $methods[] = $this->createGetter($property);
        }

        $variables = $context->getVariables();
        $variables[TemplateVariable::METHODS] = array_values(array_filter($methods));

        return $context->setVariables($variables);
    }

    /**
     * Creates set method.
     *
     * @param Property $property
     *
     * @return array
     */
    private function createSetter(Property $property): array
    {
        if (!$property->hasSetter()) {
            return [];
        }

        $name = $property->getName();
        $types = implode('|', $property->getTypes());

        return [
            'annotation'  => '',
            'name'        => 'set' . ucfirst($name),
            'parameters'  => $types . ' $' . $name,
            'return_type' => 'static',
            'body'        => '$this->' . $name . ' = $' . $name . ';',
        ];
    }

    /**
     * Creates get method.
     *
     * @param Property $property
     *
     * @return array
     */
    private function createGetter(Property $property): array
    {
        if (!$property->hasGetter()) {
            return [];
        }

        return [
            'annotation'  => '',
            'name'        => 'get' . ucfirst($property->getName()),
            'parameters'  => '',
            'return_type' => implode('|', $property->getTypes()),
            'body'        => 'return $this->' . $property->getName() . ';',
        ];
    }
}