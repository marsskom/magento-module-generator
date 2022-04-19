<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Model\Context\Context;
use Mockery;

class ContextFactory
{
    /**
     * Returns mocked context.
     *
     * @param array $userInput
     *
     * @return ContextInterface
     */
    public function getMockedContext(array $userInput): ContextInterface
    {
        return new Context(
            Mockery::mock(TemplateInterface::class),
            Mockery::mock(InterruptInterface::class),
            '',
            '',
            $userInput
        );
    }
}
