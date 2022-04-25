<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Scope;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Exception\Scope\VariableTypeException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Test\Unit\Mock\Sequence\FakeContextRegister;
use Marsskom\Generator\Test\Unit\MockHelper\ScopeFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class VariableTest extends MockeryTestCase
{
    private ScopeInterface $scope;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp()
    {
        $this->scope = (new FakeContextRegister())->execute((new ScopeFactory())->create([
            InputParameter::MODULE => 'Test_test',
            InputParameter::PATH   => './',
            InputParameter::NAME   => 'test.php',
        ]));
    }

    /**
     * @inheritdoc
     */
    protected function mockeryTestTearDown()
    {
        unset($this->scope);
    }

    /**
     * Tests get not exists variable.
     *
     * @return void
     */
    public function testGetNotExistsVariable(): void
    {
        $this->expectException(VariableNotExistsException::class);

        $this->scope->var()->get('not_exists_variable_name');
    }

    /**
     * Tests set not exists variable.
     *
     * @return void
     */
    public function testSetNotExistsVariable(): void
    {
        $this->expectException(VariableNotExistsException::class);

        $this->scope->var()->set('not_exists_variable_name', 1);
    }

    /**
     * Tests set not array type for multiple variable.
     *
     * @return void
     */
    public function testNotArrayTypeVariable(): void
    {
        $this->expectException(VariableTypeException::class);

        $this->scope->var()->set('str_as_array', 1);
    }

    /**
     * Tests rewrite non-rewritable variable.
     *
     * @return void
     */
    public function testRewriteNonRewritableVariable(): void
    {
        $this->expectException(VariableAlreadySetException::class);

        $this->scope->var()->set('str_as_array', [1]);
        $this->scope->var()->set('str_as_array', [2]);
    }

    /**
     * Tests an add value into simple variable.
     *
     * @return void
     */
    public function testAddValueIntoSimpleVariable(): void
    {
        $this->expectException(VariableIsNotMultipleException::class);

        $this->scope->var()->set('simple', 1);
        $this->scope->var()->add('simple', 2);
    }
}
