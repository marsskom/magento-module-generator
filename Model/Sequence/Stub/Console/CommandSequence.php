<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Console;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Writer\PhpWriter;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ClassNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use function array_merge;

class CommandSequence extends Sequence
{
    /**
     * @inheritdoc
     *
     * @param GlobalFactory $globalFactory
     */
    public function __construct(
        GlobalFactory $globalFactory,
        array $sequences = []
    ) {
        parent::__construct(array_merge([
            $globalFactory->create(CommandContextRegister::class),
            $globalFactory->create(NamespaceGenerator::class),
            $globalFactory->create(ClassNameGenerator::class),
            $globalFactory->create(CommandGenerator::class),
            $globalFactory->create(CommandStubGenerator::class),
            $globalFactory->create(PhpWriter::class),
        ], $sequences));
    }
}
