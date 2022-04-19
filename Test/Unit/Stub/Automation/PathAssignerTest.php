<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Stub\Automation;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathAssigner;
use Marsskom\Generator\Test\Unit\Mock\Helper\Path;
use Marsskom\Generator\Test\Unit\MockHelper\ContextFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use function implode;
use function rtrim;
use function sys_get_temp_dir;
use const DIRECTORY_SEPARATOR;

class PathAssignerTest extends MockeryTestCase
{
    private ContextInterface $context;

    /**
     * @inheritdoc
     */
    protected function mockeryTestSetUp(): void
    {
        $this->context = (new ContextFactory())->getMockedContext([
            InputParameter::MODULE => 'Test_test',
            InputParameter::PATH   => 'path/to/file',
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function mockeryTestTearDown(): void
    {
        unset($this->context);
    }

    /**
     * Tests path that not changed.
     *
     * @return void
     * @throws FileSystemException
     */
    public function testNonChangeablePath(): void
    {
        $pathAssigner = new PathAssigner(new Path());

        $context = $pathAssigner->execute($this->context);

        $expectedPath = implode(
            DIRECTORY_SEPARATOR,
            [
                sys_get_temp_dir(),
                'Test',
                'test',
                'path/to/file',
            ]
        );
        $this->assertEquals(
            rtrim($expectedPath, DIRECTORY_SEPARATOR),
            rtrim($context->getPath(), DIRECTORY_SEPARATOR)
        );
    }

    /**
     * Tests relative path.
     *
     * @return void
     * @throws FileSystemException
     */
    public function testRelativePath(): void
    {
        $pathAssigner = new PathAssigner(
            new Path(),
            'one/more/folder'
        );

        $context = $pathAssigner->execute($this->context);

        $expectedPath = implode(
            DIRECTORY_SEPARATOR,
            [
                sys_get_temp_dir(),
                'Test',
                'test',
                'path/to/file/one/more/folder',
            ]
        );
        $this->assertEquals(
            rtrim($expectedPath, DIRECTORY_SEPARATOR),
            rtrim($context->getPath(), DIRECTORY_SEPARATOR)
        );
    }

    /**
     * Tests absolute path.
     *
     * @return void
     * @throws FileSystemException
     */
    public function testAbsolutePath(): void
    {
        $pathAssigner = new PathAssigner(
            new Path(),
            'new/path/to',
            true
        );

        $context = $pathAssigner->execute($this->context);

        $expectedPath = implode(
            DIRECTORY_SEPARATOR,
            [
                sys_get_temp_dir(),
                'Test',
                'test',
                'new/path/to',
            ]
        );
        $this->assertEquals(
            rtrim($expectedPath, DIRECTORY_SEPARATOR),
            rtrim($context->getPath(), DIRECTORY_SEPARATOR)
        );
    }
}
