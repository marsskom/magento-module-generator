<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Validator;

use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;
use Marsskom\Generator\Test\Unit\Mock\Validator\EmptyValidator;
use Marsskom\Generator\Test\Unit\Mock\Validator\NonEmptyValidator;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ValidatorTest extends MockeryTestCase
{
    /**
     * Tests passed validation.
     *
     * @return void
     */
    public function testPassedValidation(): void
    {
        $validator = new EmptyValidator(new ValidatorResultBuilder());

        $validateResult = $validator->validate([1, 2, 3]);

        $this->assertTrue($validateResult->isValid());
    }

    /**
     * Tests failed validation.
     *
     * @return void
     */
    public function testFailedValidation(): void
    {
        $validator = new EmptyValidator(new ValidatorResultBuilder());

        $validateResult = $validator->validate([]);

        $this->assertFalse($validateResult->isValid());

        $this->assertEquals(
            'User input is empty',
            $validateResult->getMessage()
        );
    }

    /**
     * Tests next validator.
     *
     * @return void
     */
    public function testNextValidator(): void
    {
        $validator = new EmptyValidator(new ValidatorResultBuilder());
        $validator->setNext(new NonEmptyValidator(new ValidatorResultBuilder()));

        $validateResult = $validator->validate([1, 2, 3]);

        $this->assertFalse($validateResult->isValid());

        $this->assertEquals(
            "User input isn't empty",
            $validateResult->getMessage()
        );
    }
}
