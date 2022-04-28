<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain;

use Marsskom\Generator\Domain\Interfaces\CallableInterface;
use Marsskom\Generator\Test\Unit\Domain\Mock\SumPipeline;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CallableTest extends MockeryTestCase
{
    /**
     * Tests callback class.
     *
     * @return void
     */
    public function testCallback(): void
    {
        $mock = Mockery::mock(CallableInterface::class);
        $mock->shouldReceive('__invoke')
             ->andReturnUsing(fn($a, $b) => $a + $b);

        $this->assertSame(
            5,
            $mock(2, 3)
        );
    }

    /**
     * Tests callbacks pipeline.
     *
     * @return void
     */
    public function testPipeline(): void
    {
        $mock = Mockery::mock(CallableInterface::class);
        $mock->shouldReceive('__invoke')
             ->andReturnUsing(fn($a, $b) => $a + $b);

        $obj = new SumPipeline([
            fn($a, $b) => $a * $b,
            $mock,
        ]);

        $this->assertSame(
            11,
            $obj(2, 3)
        );
    }

    /**
     * Tests callbacks complex pipeline.
     *
     * @return void
     */
    public function testComplexPipeline(): void
    {
        $mock = Mockery::mock(CallableInterface::class);
        $mock->shouldReceive('__invoke')
             ->andReturnUsing(fn($a, $b) => $a + $b);

        $obj = new SumPipeline([
            fn($a, $b) => $a * $b,
            new SumPipeline([
                $mock,
                fn($a, $b) => $a - $b,
            ]),
            $mock,
        ]);

        $this->assertSame(
            15,
            $obj(2, 3)
        );
    }
}
