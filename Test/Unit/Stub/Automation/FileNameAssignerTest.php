<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Stub\Automation;

use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Model\Context\Context;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameAssigner;
use PHPUnit\Framework\TestCase;

class FileNameAssignerTest extends TestCase
{
    /**
     * Tests file name assignment.
     *
     * @return void
     */
    public function testExecute(): void
    {
        $fileName = 'file.dot';

        $context = new Context(
            $this->createMock(TemplateInterface::class),
            $this->createMock(InterruptInterface::class)
        );
        $fileNameAssigner = new FileNameAssigner($fileName);

        $context = $fileNameAssigner->execute($context);

        $this->assertEquals($fileName, $context->getFileName());
    }
}
