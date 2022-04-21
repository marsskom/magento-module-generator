<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Validator\Entity;

use Marsskom\Generator\Api\Data\Validator\ValidatorInterface;
use Marsskom\Generator\Exception\Entity\PropertyStringIsInvalid;
use Marsskom\Generator\Exception\ValidateException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\InputParser\Entity\PropertiesParser;
use Marsskom\Generator\Model\Validator\Validator;

class PropertiesValidator extends Validator
{
    private PropertiesParser $parser;

    /**
     * Validator constructor.
     *
     * @param PropertiesParser        $parser
     * @param null|ValidatorInterface $next
     */
    public function __construct(
        PropertiesParser $parser,
        ?ValidatorInterface $next = null
    ) {
        parent::__construct($next);

        $this->parser = $parser;
    }

    /**
     * @inheritdoc
     */
    protected function concreteValidate(array $userInput): void
    {
        $propertiesString = $userInput[InputParameter::PROPERTIES] ?? '';

        if (empty($propertiesString)) {
            return;
        }

        try {
            $this->parser->parse($propertiesString);
        } catch (PropertyStringIsInvalid $exception) {
            throw new ValidateException(__($exception->getMessage()));
        }
    }
}
