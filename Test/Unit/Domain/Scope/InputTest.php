<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Context\InputNotExistsException;
use Marsskom\Generator\Domain\Scope\Context\Input;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use TypeError;

class InputTest extends MockeryTestCase
{
    /**
     * Tests constructor.
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $this->expectException(TypeError::class);

        new Input(['a' => null]);
    }

    /**
     * Tests input option.
     *
     * @return void
     *
     * @throws InputNotExistsException
     */
    public function testInputOption(): void
    {
        $input = new Input(['a' => 'b']);

        $this->assertEquals('b', $input->get('a'));
    }

    /**
     * Tests input option existence.
     *
     * @return void
     */
    public function testExistence(): void
    {
        $input = new Input(['a' => 'b']);

        $this->assertTrue($input->has('a'));
    }

    /**
     * Tests input option array.
     *
     * @return void
     */
    public function testArray(): void
    {
        $input = new Input([
            'a' => 1,
            'b' => 2,
        ]);

        $all = $input->getAll();

        $this->assertCount(2, $all);
        $this->assertContains(1, $all);
        $this->assertContains(2, $all);
        $this->assertArrayHasKey('a', $all);
        $this->assertArrayHasKey('b', $all);
    }

    /**
     * Tests not exists exception.
     *
     * @return void
     *
     * @throws InputNotExistsException
     */
    public function testNotExistsException(): void
    {
        $this->expectException(InputNotExistsException::class);

        (new Input(['a' => 'b']))->get('not_exists');
    }
}
