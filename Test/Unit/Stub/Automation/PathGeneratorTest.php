<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Stub\Automation;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;
use Marsskom\Generator\Test\Unit\Mock\Helper\Path;
use Marsskom\Generator\Test\Unit\MockHelper\ScopeFactory;
use PHPUnit\Framework\TestCase;
use function implode;
use function rtrim;
use function sys_get_temp_dir;
use const DIRECTORY_SEPARATOR;

class PathGeneratorTest extends TestCase
{
    /**
     * Tests path generator to module.
     *
     * @return void
     *
     * @throws FileSystemException
     */
    public function testModulePath(): void
    {
        $pathGenerator = new PathGenerator(new Path());

        $scope = $pathGenerator->execute(
            (new ScopeFactory())->create([
                InputParameter::MODULE => 'Test_test',
                InputParameter::PATH   => '',
            ])
        );

        $expectedPath = implode(
            DIRECTORY_SEPARATOR,
            [
                sys_get_temp_dir(),
                'Test',
                'test',
            ]
        );
        $this->assertEquals(
            rtrim($expectedPath, DIRECTORY_SEPARATOR),
            rtrim($scope->context()->getPath(), DIRECTORY_SEPARATOR)
        );
    }

    /**
     * Tests path generator to directory.
     *
     * @return void
     *
     * @throws FileSystemException
     */
    public function testDirectoryPath(): void
    {
        $pathGenerator = new PathGenerator(new Path());

        $scope = $pathGenerator->execute(
            (new ScopeFactory())->create([
                InputParameter::MODULE => 'Test_test',
                InputParameter::PATH   => 'path/to/file',
            ])
        );

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
            rtrim($scope->context()->getPath(), DIRECTORY_SEPARATOR)
        );
    }
}
