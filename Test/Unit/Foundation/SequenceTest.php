<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Foundation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Test\Unit\Mock\Automation\MultiplierGenerator;
use Marsskom\Generator\Test\Unit\Mock\Sequence\SimpleSequence;
use Marsskom\Generator\Test\Unit\Mock\TemplateEngine\TemplateFromArray;
use Marsskom\Generator\Test\Unit\MockHelper\ScopeFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function implode;

class SequenceTest extends MockeryTestCase
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
     * Tests generator queue.
     *
     * @return void
     *
     * @throws VariableNotExistsException
     */
    public function testQueueWithContextVariables(): void
    {
        $string = '0123456789';

        $sequence = new SimpleSequence($string);
        $scope = $sequence->execute($this->scope);

        $this->assertEquals(
            $string,
            implode('', $scope->var()->get('simple_generator') ?? [])
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

        $this->scope->context()->setTemplate(new TemplateFromArray());
        $scope = $sequence->execute($this->scope);

        $this->assertEquals(
            $string,
            (string) $scope->context()->getTemplate()
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

        $this->scope->context()->setTemplate(new TemplateFromArray());
        $scope = $sequence->execute($this->scope);

        $this->assertEquals(
            '246810121416180',
            (string) $scope->context()->getTemplate()
        );
    }
}
