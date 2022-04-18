<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Automation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Test\Unit\Mock\TemplateEngine\TemplateFromArray;

class WriterAsArray extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        return $context->setTemplate(
            new TemplateFromArray($context->getVariables())
        );
    }
}
