<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Foundation;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Model\Context\Context;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Test\Unit\Mock\Automation\MultiplierGenerator;
use Marsskom\Generator\Test\Unit\Mock\Sequence\SimpleSequence;
use Marsskom\Generator\Test\Unit\Mock\TemplateEngine\TemplateFromArray;
use PHPUnit\Framework\TestCase;
use function implode;

class SequenceTest extends TestCase
{
    /**
     * Tests generator queue.
     *
     * @return void
     */
    public function testQueueWithContextVariables(): void
    {
        $string = '0123456789';

        $context = new Context(
            $this->createMock(TemplateInterface::class),
            '',
            '',
            [
                InputParameter::MODULE => '',
                InputParameter::PATH   => '',
            ]
        );

        $sequence = new SimpleSequence($string);
        $context = $sequence->execute($context);

        $this->assertEquals(
            $string,
            implode('', $context->getVariables())
        );
    }

    /**
     * Tests generator queue.
     *
     * @return void
     */
    public function testQueueWithTemplate(): void
    {
        $string = '9876543210';

        $context = new Context(
            new TemplateFromArray(),
            '',
            '',
            [
                InputParameter::MODULE => '',
                InputParameter::PATH   => '',
            ]
        );

        $sequence = new SimpleSequence($string);
        $context = $sequence->execute($context);

        $this->assertEquals(
            $string,
            (string) $context->getTemplate()
        );
    }

    /**
     * Tests change values in sequence.
     *
     * @return void
     */
    public function testChangeValues(): void
    {
        $string = '1234567890';

        $context = new Context(
            new TemplateFromArray(),
            '',
            '',
            [
                InputParameter::MODULE => '',
                InputParameter::PATH   => '',
            ]
        );

        $sequence = new SimpleSequence(
            $string,
            [new MultiplierGenerator(2)]
        );
        $context = $sequence->execute($context);

        $this->assertEquals(
            '246810121416180',
            (string) $context->getTemplate()
        );
    }
}
