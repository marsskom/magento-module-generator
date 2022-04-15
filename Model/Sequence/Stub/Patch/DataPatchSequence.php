<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Patch;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ClassNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PhpFileNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;

class DataPatchSequence extends Sequence
{
    /**
     * @inheritdoc
     */
    public function __construct(
        PathGenerator $path,
        PhpFileNameGenerator $fileName,
        NamespaceGenerator $namespace,
        ClassNameGenerator $class,
        DataPatchGenerator $dataPatch,
        Writer $writer,
        array $sequences = []
    ) {
        parent::__construct(array_merge([
            $path,
            $fileName,
            $namespace,
            $class,
            $dataPatch,
            $writer,
        ], $sequences));
    }
}
