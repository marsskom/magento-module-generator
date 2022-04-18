<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\MockHelper;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Model\Context\Context;
use PHPUnit\Framework\TestCase;

class ContextFactory extends TestCase
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
            $this->createMock(TemplateInterface::class),
            $this->createMock(InterruptInterface::class),
            '',
            '',
            $userInput
        );
    }
}
