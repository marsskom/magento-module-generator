<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Stub\Automation;

use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameAssigner;
use Marsskom\Generator\Test\Unit\MockHelper\ScopeFactory;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class FileNameAssignerTest extends MockeryTestCase
{
    /**
     * Tests file name assignment.
     *
     * @return void
     */
    public function testExecute(): void
    {
        $fileName = 'file.dot';
        $fileNameAssigner = new FileNameAssigner($fileName);

        $scope = $fileNameAssigner->execute(
            (new ScopeFactory())->create([])
        );

        $this->assertEquals($fileName, $scope->context()->getFileName());
    }
}
