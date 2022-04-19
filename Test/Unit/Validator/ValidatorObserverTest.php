<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Validator;

use Marsskom\Generator\Model\Validator\ValidatorObserver;
use Marsskom\Generator\Model\Validator\ValidatorResultBuilder;
use Marsskom\Generator\Test\Unit\Mock\Console\Command;
use Marsskom\Generator\Test\Unit\Mock\Validator\EmptyValidator;
use Marsskom\Generator\Test\Unit\Mock\Validator\NonEmptyValidator;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function get_class;

class ValidatorObserverTest extends MockeryTestCase
{
    private ValidatorObserver $validatorObserver;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp()
    {
        $this->validatorObserver = new ValidatorObserver(new ValidatorResultBuilder());
    }

    /**
     * @inheritdoc
     */
    protected function mockeryTestTearDown()
    {
        unset($this->validatorObserver);
    }

    /**
     * Tests empty observers list.
     *
     * @return void
     */
    public function testEmptyObservers(): void
    {
        $command = new Command($this->validatorObserver);

        $validateResult = $command->execute([]);

        $this->assertTrue($validateResult->isValid());
    }

    /**
     * Tests validator attachment.
     *
     * @return void
     */
    public function testAttach(): void
    {
        $command = new Command($this->validatorObserver);

        $validator = new EmptyValidator(new ValidatorResultBuilder());
        $this->validatorObserver->attach(get_class($command), $validator);

        $validateResult = $command->execute([1, 2, 3]);

        $this->assertTrue($validateResult->isValid());
    }

    /**
     * Test validators order.
     *
     * @return void
     */
    public function testValidatorOrder(): void
    {
        $command = new Command($this->validatorObserver);

        $emptyValidator = new EmptyValidator(new ValidatorResultBuilder());

        $this->validatorObserver->attach(
            get_class($command),
            $emptyValidator
        );
        $this->validatorObserver->attach(
            get_class($command),
            new NonEmptyValidator(new ValidatorResultBuilder())
        );
        $this->validatorObserver->attach(
            get_class($command),
            new EmptyValidator(new ValidatorResultBuilder())
        );

        $this->assertEquals(EmptyValidator::class, get_class($emptyValidator));

        $validator = $emptyValidator->getNext();
        $this->assertEquals(NonEmptyValidator::class, get_class($validator));

        $validator = $validator->getNext();
        $this->assertEquals(EmptyValidator::class, get_class($validator));

        $validator = $validator->getNext();
        $this->assertNull($validator);
    }

    /**
     * Tests multiply attachment.
     *
     * @param array  $userInput
     * @param bool   $isValid
     * @param string $message
     *
     * @return void
     *
     * @dataProvider attachMultipleDataProvider
     */
    public function testAttachMultiple(array $userInput, bool $isValid, string $message): void
    {
        $command = new Command($this->validatorObserver);

        $this->validatorObserver->attach(
            get_class($command),
            new NonEmptyValidator(new ValidatorResultBuilder())
        );
        $this->validatorObserver->attach(
            get_class($command),
            new EmptyValidator(new ValidatorResultBuilder())
        );

        $validateResult = $command->execute($userInput);

        $this->assertSame($isValid, $validateResult->isValid());
        $this->assertEquals($message, $validateResult->getMessage());
    }

    /**
     * Returns data provider for attach multiple.
     *
     * @return array[][]
     */
    public function attachMultipleDataProvider(): array
    {
        return [
            [
                [1, 2, 3],
                false,
                "User input isn't empty",
            ],
            [
                [],
                false,
                "User input is empty",
            ],
        ];
    }
}
