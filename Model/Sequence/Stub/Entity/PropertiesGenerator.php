<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Entity\PropertyStringIsInvalidException;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Entity\Property;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\InputParser\Entity\PropertiesParser;
use function implode;

class PropertiesGenerator extends AbstractSequence
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
     * @throws PropertyStringIsInvalidException
     * @throws VariableAlreadySetException
     * @throws VariableNotExistsException
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $propsObjects = $this->parser->parse(
            $scope->input()->get(InputParameter::PROPERTIES) ?? ''
        );

        $properties = [];
        foreach ($propsObjects as $property) {
            $properties[] = $this->getPropertyString($property);
        }

        $scope->var()->set(
            TemplateVariable::CLASS_PROPERTIES,
            $properties
        );

        return $scope;
    }

    /**
     * Returns property as string.
     *
     * @param Property $property
     *
     * @return string
     */
    protected function getPropertyString(Property $property): string
    {
        return 'private ' . implode('|', $property->getTypes()) . ' $' . $property->getName() . ';';
    }
}
