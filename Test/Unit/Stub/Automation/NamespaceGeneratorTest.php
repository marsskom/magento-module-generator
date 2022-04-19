<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Stub\Automation;

use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use Marsskom\Generator\Test\Unit\MockHelper\ContextFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class NamespaceGeneratorTest extends MockeryTestCase
{
    /**
     * Tests namespace.
     *
     * @return void
     */
    public function testExecute(): void
    {
        $namespaceGenerator = new NamespaceGenerator(new ModuleBuilder());

        $context = $namespaceGenerator->execute(
            (new ContextFactory())->getMockedContext([
                InputParameter::MODULE => 'Test_test',
                InputParameter::PATH   => 'path/to/file',
            ])
        );

        $this->assertEquals(
            'Test\\test\\path\\to\\file',
            $context->getVariables()[TemplateVariable::FILE_NAMESPACE]
        );
    }
}
