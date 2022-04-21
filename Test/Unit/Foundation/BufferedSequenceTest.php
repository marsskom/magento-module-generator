<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Foundation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Context\BufferBuilder;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\BufferedSequence;
use Marsskom\Generator\Test\Unit\Mock\Sequence\SimpleSequence;
use Marsskom\Generator\Test\Unit\MockHelper\ContextFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function spl_object_id;

class BufferedSequenceTest extends MockeryTestCase
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
     * Tests simple sequence object identities.
     *
     * @return void
     */
    public function testSequenceObjectIds(): void
    {
        $string = '0123456789';
        $sequence = new SimpleSequence($string);
        $context = $sequence->execute($this->context);

        $this->assertEquals(
            spl_object_id($this->context),
            spl_object_id($context),
        );
    }

    /**
     * Tests buffered sequence object identities.
     *
     * @return void
     */
    public function testBufferedSequenceObjectIds(): void
    {
        $sequence = new BufferedSequence(new BufferBuilder());
        $context = $sequence->execute($this->context);

        $this->assertNotEquals(
            spl_object_id($this->context),
            spl_object_id($context),
        );
    }
}
