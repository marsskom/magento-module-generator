<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Foundation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Context\BufferBuilder;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\BufferedSequence;
use Marsskom\Generator\Test\Unit\Mock\Sequence\SimpleSequence;
use Marsskom\Generator\Test\Unit\MockHelper\ScopeFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function spl_object_id;

class BufferedSequenceTest extends MockeryTestCase
{
    private ScopeInterface $scope;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp(): void
    {
        $this->scope = (new ScopeFactory())->create(
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
        unset($this->scope);
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
        $scope = $sequence->execute($this->scope);

        $this->assertEquals(
            spl_object_id($this->scope),
            spl_object_id($scope),
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
        $scope = $sequence->execute($this->scope);

        $this->assertNotEquals(
            spl_object_id($this->scope),
            spl_object_id($scope),
        );
    }
}
