<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Validator\Console;

use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use Marsskom\Generator\Model\Validator\Console\ModuleValidator;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use PHPUnit\Framework\Exception;

class ModuleValidatorTest extends MockeryTestCase
{
    private ModuleValidator $validator;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp(): void
    {
        $this->validator = new ModuleValidator(
            new ModuleBuilder(),
            new ValidatorResultBuilder(),
        );
    }

    /**
     * @inheritdoc
     */
    protected function mockeryTestTearDown(): void
    {
        unset($this->validator);
    }

    /**
     * Tests passed validation.
     *
     * @return void
     */
    public function testPassedValidation(): void
    {
        $validateResult = $this->validator->validate([
            InputParameter::MODULE => 'Test_test',
        ]);

        $this->assertTrue($validateResult->isValid());
    }

    /**
     * Tests failed validation.
     *
     * @return void
     */
    public function testFailedValidation(): void
    {
        $validateResult = $this->validator->validate([
            InputParameter::MODULE => 'Test_',
        ]);

        $this->assertFalse($validateResult->isValid());
    }

    /**
     * Tests exception.
     *
     * @return void
     */
    public function testException(): void
    {
        $this->expectException(Exception::class);

        $this->validator->validate([
            InputParameter::MODULE => 'TestTest',
        ]);
    }
}
