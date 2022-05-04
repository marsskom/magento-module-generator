<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Callables;

use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Magento\Exception\PropertyStringIsInvalidException;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Input\Property;
use Marsskom\Generator\Magento\Model\Parser\PropertiesParser;

class PropertiesCallable
{
    /**
     * Invoke method.
     *
     * @param ContextInterface $c
     * @param InputInterface   $i
     *
     * @return ContextInterface
     *
     * @throws InputNotExistsException
     * @throws PropertyStringIsInvalidException
     */
    public function __invoke(ContextInterface $c, InputInterface $i): ContextInterface
    {
        $propsObjects = (new PropertiesParser())->parse($i->get(InputParameter::PROPERTIES));

        $properties = [];
        foreach ($propsObjects as $property) {
            $properties[] = $this->getPropertyString($property);
        }

        return $c->set(TemplateVariable::CLASS_PROPERTIES, $properties);
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
