<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Model\Context\Context;
use Mockery;

class ContextFactory
{
    /**
     * Returns mocked context.
     *
     * @return ContextInterface
     */
    public function create(): ContextInterface
    {
        return new Context(
            Mockery::mock(TemplateInterface::class),
            '',
            ''
        );
    }
}
