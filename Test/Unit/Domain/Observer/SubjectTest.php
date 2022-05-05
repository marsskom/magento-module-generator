<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Observer;

use Marsskom\Generator\Domain\Exception\Observer\EventNameNotExistsException;
use Marsskom\Generator\Test\Unit\Domain\Mock\Observer\InArrayComplexObserver;
use Marsskom\Generator\Test\Unit\Domain\Mock\Observer\IntArrayObserver;
use Marsskom\Generator\Test\Unit\Domain\Mock\Observer\IntArraySubject;
use Marsskom\Generator\Test\Unit\Domain\Mock\Observer\IntValue;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function implode;

class SubjectTest extends MockeryTestCase
{
    /**
     * Test simple observer.
     *
     * @throws EventNameNotExistsException
     */
    public function testSimpleObserver(): void
    {
        /** @var $subject IntArraySubject */
        $subject = (new IntArraySubject())->attach('*', new IntArrayObserver());
        $subject->trigger('*', new IntValue(1));
        $subject->trigger('*', new IntValue(2));
        $subject->trigger('*', new IntValue(3));

        $this->assertCount(3, $subject->get());

        $this->assertEquals(
            123,
            (int) implode('', $subject->get())
        );
    }

    /**
     * Tests complex observer.
     *
     * @return void
     *
     * @throws EventNameNotExistsException
     */
    public function testComplexObservers(): void
    {
        /** @var $subject IntArraySubject */
        $subject = (new IntArraySubject())
            ->attach('*', new IntArrayObserver())
            ->attach(
                '*',
                (new InArrayComplexObserver())
                    ->attach('*', new IntArrayObserver())
                    ->attach('*', new IntArrayObserver())
            );
        $subject->trigger('*', new IntValue(1));
        $subject->trigger('*', new IntValue(2));
        $subject->trigger('*', new IntValue(3));

        $this->assertCount(9, $subject->get());

        $this->assertEquals(
            111222333,
            (int) implode('', $subject->get())
        );
    }

    /**
     * Tests event not found exception.
     *
     * @return void
     *
     * @throws EventNameNotExistsException
     */
    public function testEventNotFoundException(): void
    {
        $this->expectException(EventNameNotExistsException::class);

        $subject = (new IntArraySubject())->attach('*', new IntArrayObserver());
        $subject->trigger('not_exists_event', new IntValue(1));
    }
}
