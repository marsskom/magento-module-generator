<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper\Context;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use function sha1;

class IdHelper
{
    /**
     * Returns id for context.
     *
     * @param ContextInterface $context
     *
     * @return string
     */
    public function getId(ContextInterface $context): string
    {
        return sha1($context->getPath() . $context->getFileName());
    }
}
