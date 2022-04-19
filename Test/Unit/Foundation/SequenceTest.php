<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Foundation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Test\Unit\Mock\Automation\MultiplierGenerator;
use Marsskom\Generator\Test\Unit\Mock\Sequence\SimpleSequence;
use Marsskom\Generator\Test\Unit\Mock\TemplateEngine\TemplateFromArray;
use Marsskom\Generator\Test\Unit\MockHelper\ContextFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function implode;

class SequenceTest extends MockeryTestCase
{
    private ContextInterface $context;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp(): void
    {
        $this->context = (new ContextFactory())->getMockedContext(
            [
                InputParameter::MODULE => '',
                InputParameter::PATH   => '',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function mockeryTestTearDown(): void
    {
        unset($this->context);
    }

    /**
     * Tests generator queue.
     *
     * @return void
     */
    public function testQueueWithContextVariables(): void
    {
        $string = '0123456789';

        $sequence = new SimpleSequence($string);
        $context = $sequence->execute($this->context);

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

        $sequence = new SimpleSequence($string);
        $context = $sequence->execute(
            $this->context->setTemplate(new TemplateFromArray())
        );

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

        $sequence = new SimpleSequence(
            $string,
            [new MultiplierGenerator(2)]
        );
        $context = $sequence->execute(
            $this->context->setTemplate(new TemplateFromArray())
        );

        $this->assertEquals(
            '246810121416180',
            (string) $context->getTemplate()
        );
    }
}
