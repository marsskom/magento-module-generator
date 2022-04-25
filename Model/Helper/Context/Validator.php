<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper\Context;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Exception\Context\ContextIncorrectException;

class Validator
{
    /**
     * Validates context.
     *
     * @param ContextInterface $context
     *
     * @return void
     *
     * @throws ContextIncorrectException
     */
    public function validate(ContextInterface $context): void
    {
        if (empty($context->getFileName())) {
            throw new ContextIncorrectException(__("Context file name is empty. Did you register the context?"));
        }

        if (empty($context->getPath())) {
            throw new ContextIncorrectException(__("Context path is empty. Did you register the context?"));
        }
    }
}
