<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Validator\Console;

use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Validator\Console\NameValidator;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class NameValidatorTest extends MockeryTestCase
{
    private NameValidator $validator;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp(): void
    {
        $this->validator = new NameValidator(new ValidatorResultBuilder());
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
            InputParameter::NAME => 'NameHere',
        ]);

        $this->assertTrue($validateResult->isValid());
    }

    /**
     * Tests failed validation.
     *
     * @return void
     */
    public function testFailedValidationOnEmptyValue(): void
    {
        $validateResult = $this->validator->validate([
            InputParameter::NAME => '',
        ]);

        $this->assertFalse($validateResult->isValid());
    }

    /**
     * Tests failed validation.
     *
     * @return void
     */
    public function testFailedValidationOnValueWithSpace(): void
    {
        $validateResult = $this->validator->validate([
            InputParameter::NAME => 'Invalid Name',
        ]);

        $this->assertFalse($validateResult->isValid());
    }

    /**
     * Tests failed validation.
     *
     * @return void
     */
    public function testFailedValidationOnValueWithDeniedCharacters(): void
    {
        $validateResult = $this->validator->validate([
            InputParameter::NAME => 'In%valid.N^ame',
        ]);

        $this->assertFalse($validateResult->isValid());
    }

    /**
     * Tests failed validation.
     *
     * @return void
     */
    public function testFailedValidationWhereFirstCharacterIsNumber(): void
    {
        $validateResult = $this->validator->validate([
            InputParameter::NAME => '3ClasTest',
        ]);

        $this->assertFalse($validateResult->isValid());
    }
}
