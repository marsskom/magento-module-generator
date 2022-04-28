<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Domain\Scope;

use Marsskom\Generator\Domain\Exception\Context\VariableNotExistsException;
use Marsskom\Generator\Domain\Scope\Context;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function implode;

class ContextTest extends MockeryTestCase
{
    /**
     * Tests immutability.
     *
     * @return void
     */
    public function testImmutability(): void
    {
        $context = new Context();
        $varContext = $context->set('variable', 'value');

        $this->assertFalse($context->has('variable'));
        $this->assertTrue($varContext->has('variable'));
    }

    /**
     * Tests set variable into context.
     *
     * @return void
     */
    public function testSetIntoContext(): void
    {
        $context = (new Context())
            ->set('first', 'value')
            ->set('second', 'value2');

        $variables = $context->getAll();

        $this->assertCount(2, $variables);
        $this->assertArrayHasKey('first', $variables);
        $this->assertArrayHasKey('second', $variables);
        $this->assertContains('value', $variables);
        $this->assertContains('value2', $variables);
    }

    /**
     * Tests rewrite variable.
     *
     * @return void
     *
     * @throws VariableNotExistsException
     */
    public function testRewriteVariableInContext(): void
    {
        $context = (new Context())
            ->set('variable', 'value');

        $this->assertEquals('value', $context->get('variable'));

        $context = $context->set('variable', 'second_value');

        $this->assertEquals('second_value', $context->get('variable'));
    }

    /**
     * Tests array variable in context.
     *
     * @return void
     *
     * @throws VariableNotExistsException
     */
    public function testArrayVariable(): void
    {
        $context = (new Context())
            ->set('variable', 1)
            ->add('variable', 2);

        $this->assertEquals(
            12,
            implode('', $context->get('variable'))
        );
    }

    /**
     * Tests an variable unset.
     *
     * @return void
     *
     * @throws VariableNotExistsException
     */
    public function testUnsetVariable(): void
    {
        $context = (new Context())
            ->set('variable', 1)
            ->unset('variable');

        $this->assertFalse($context->has('variable'));
    }

    /**
     * Tests variable not exists exception.
     *
     * @return void
     *
     * @throws VariableNotExistsException
     */
    public function testVariableNotExistsException(): void
    {
        $this->expectException(VariableNotExistsException::class);

        (new Context())->get('not_exists');
    }
}
