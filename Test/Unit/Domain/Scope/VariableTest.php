<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Scope;

use Marsskom\Generator\Domain\Scope\Context\Variable;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class VariableTest extends MockeryTestCase
{
    /**
     * Tests variable class.
     *
     * @return void
     */
    public function testVariable(): void
    {
        $var = new Variable('test', 'value');

        $this->assertEquals('test', $var->name());
        $this->assertEquals('value', $var->value());
    }
}
