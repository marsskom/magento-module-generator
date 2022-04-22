<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Stub\Automation;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use Marsskom\Generator\Test\Unit\Mock\Helper\Path;
use Marsskom\Generator\Test\Unit\MockHelper\ScopeFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class NamespaceGeneratorTest extends MockeryTestCase
{
    /**
     * Tests namespace.
     *
     * @return void
     *
     * @throws LocalizedException
     */
    public function testExecute(): void
    {
        $namespaceGenerator = new NamespaceGenerator(new Path(), new ModuleBuilder());

        $scope = $namespaceGenerator->execute(
            (new ScopeFactory())->create([
                InputParameter::MODULE => 'Test_test',
                InputParameter::PATH   => 'path/to/file',
            ])
        );

        $this->assertEquals(
            'Test\\test\\path\\to\\file',
            $scope->var()->get(TemplateVariable::FILE_NAMESPACE)
        );
    }
}
