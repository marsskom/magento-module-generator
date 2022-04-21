<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Exception\Entity\PropertyStringIsInvalid;
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
     * @throws PropertyStringIsInvalid
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $propsObjects = $this->parser->parse(
            $context->getUserInput()[InputParameter::PROPERTIES] ?? ''
        );

        $properties = [];
        foreach ($propsObjects as $property) {
            $properties[] = 'private ' . implode('|', $property->getTypes()) . ' $' . $property->getName() . ';';
        }

        $variables = $context->getVariables();
        $variables[TemplateVariable::CLASS_PROPERTIES] = $properties;

        return $context->setVariables($variables);
    }
}
