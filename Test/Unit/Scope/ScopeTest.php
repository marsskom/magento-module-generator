<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Scope;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Exception\Scope\VariableAlreadySetException;
use Marsskom\Generator\Exception\Scope\VariableIsNotMultipleException;
use Marsskom\Generator\Exception\Scope\VariableNotExistsException;
use Marsskom\Generator\Exception\Scope\VariableTypeException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Test\Unit\Mock\Sequence\CoupleContextRegister;
use Marsskom\Generator\Test\Unit\MockHelper\ScopeFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ScopeTest extends MockeryTestCase
{
    /**
     * Tests scope context.
     *
     * @throws VariableNotExistsException
     * @throws VariableIsNotMultipleException
     * @throws VariableAlreadySetException
     * @throws VariableTypeException
     */
    public function testScopeContext(): void
    {
        $scope = (new ScopeFactory())->create([
            InputParameter::MODULE => 'Test_test',
            InputParameter::PATH   => './',
            InputParameter::NAME   => 'test.php',
        ]);

        $contextRegister = new CoupleContextRegister([
            'another_file' => [
                InputParameter::PATH => './',
                InputParameter::NAME => 'another.php',
            ],
        ]);
        $scope = $contextRegister->execute($scope);

        $scope->var()->set('str_as_array', ['1']);
        $scope->var()->add('str_as_array', '71');
        $scope->for('another_file')->add('array', 1);

        // Changes context.
        $scope = $scope->setCurrentContextFromAlias('another_file');

        $scope->var()->add('array', 9);
        $scope->for(ScopeInterface::DEFAULT_CONTEXT)->add('array', 63);
        $scope->for(ScopeInterface::DEFAULT_CONTEXT)->add('str_as_array', '6');

        $arrayVar = $scope->var()->get('array');

        $this->assertIsArray($arrayVar);
        $this->assertCount(2, $arrayVar);
        $this->assertContains(1, $arrayVar);
        $this->assertContains(9, $arrayVar);

        // Changes context into default.
        $scope = $scope->setCurrentContextFromAlias(ScopeInterface::DEFAULT_CONTEXT);

        $arrayVar = $scope->var()->get('array');
        $this->assertIsArray($arrayVar);
        $this->assertCount(1, $arrayVar);
        $this->assertContains(63, $arrayVar);

        $strAsArray = $scope->var()->get('str_as_array');
        $this->assertIsArray($strAsArray);
        $this->assertEquals('1716', $scope->var()->getAll()['str_as_array']);
    }
}
