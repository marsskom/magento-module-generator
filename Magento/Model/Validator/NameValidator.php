<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Validator;

use Marsskom\Generator\Domain\Exception\Scope\InputNotExistsException;
use Marsskom\Generator\Domain\Exception\Validator\ValidateException;
use Marsskom\Generator\Domain\Interfaces\Scope\InputInterface;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;

class NameValidator
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
    public function __invoke(InputInterface $i)
    {
        if (!$i->has(InputParameter::NAME)) {
            throw new ValidateException("Name is required.");
        }

        if (false === (bool) preg_match('/^[A-Za-z][\w_-]+?$/', $i->get(InputParameter::NAME))) {
            throw new ValidateException(
            // @codingStandardsIgnoreLine
                "Name may contain letters (first character requires only as letter), numbers, underscore (_) and minus (-) only."
            );
        }
    }
}
