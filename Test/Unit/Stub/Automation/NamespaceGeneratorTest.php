<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Stub\Automation;

use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Model\Context\Context;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use Marsskom\Generator\Model\Helper\Module;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use PHPUnit\Framework\TestCase;

class NamespaceGeneratorTest extends TestCase
{
    /**
     * Tests namespace.
     *
     * @return void
     */
    public function testExecute(): void
    {
        $context = new Context(
            $this->createMock(TemplateInterface::class),
            '',
            '',
            [
                InputParameter::MODULE => 'Test_test',
                InputParameter::PATH   => 'path/to/file',
            ]
        );

        $namespaceGenerator = new NamespaceGenerator($this->getMockModuleBuilder());
        $namespaceGenerator->execute($context);

        $this->assertEquals(
            'Test\\test\\path\\to\\file',
            $context->getVariables()[TemplateVariable::FILE_NAMESPACE]
        );
    }

    /**
     * Creates module builder mock.
     */
    protected function getMockModuleBuilder()
    {
        $mock = $this->createMock(ModuleBuilder::class);

        $mock->expects($this->once())
             ->method('fromMagentoModuleName')
             ->willReturn(new Module('Test', 'test'));

        return $mock;
    }
}
