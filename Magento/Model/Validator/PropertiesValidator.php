<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Validator;

use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Exception\Validator\ValidateException;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Magento\Exception\PropertyStringIsInvalidException;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Parser\PropertiesParser;

class PropertiesValidator
{
    /**
     * Invoke method.
     *
     * @param InputInterface $i
     *
     * @return void
     *
     * @throws ValidateException
     * @throws InputNotExistsException
     */
    public function __invoke(InputInterface $i): void
    {
        if (!$i->has(InputParameter::PROPERTIES)) {
            throw new ValidateException("Properties is required.");
        }

        try {
            (new PropertiesParser())->parse($i->get(InputParameter::PROPERTIES));
        } catch (PropertyStringIsInvalidException $exception) {
            throw new ValidateException($exception->getMessage());
        }
    }
}
