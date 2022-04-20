<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Console;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ClassNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PhpFileNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use function array_merge;

class CommandSequence extends Sequence
{
    /**
     * @inheritdoc
     *
     * @param PathGenerator        $path
     * @param PhpFileNameGenerator $fileName
     * @param NamespaceGenerator   $namespace
     * @param ClassNameGenerator   $className
     * @param CommandGenerator     $commandGenerator
     * @param CommandStubGenerator $commandStubGenerator
     * @param Writer               $writer
     */
    public function __construct(
        PathGenerator $path,
        PhpFileNameGenerator $fileName,
        NamespaceGenerator $namespace,
        ClassNameGenerator $className,
        CommandGenerator $commandGenerator,
        CommandStubGenerator $commandStubGenerator,
        Writer $writer,
        array $sequences = []
    ) {
        parent::__construct(array_merge([
            $path,
            $fileName,
            $namespace,
            $className,
            $commandGenerator,
            $commandStubGenerator,
            $writer,
        ], $sequences));
    }
}
