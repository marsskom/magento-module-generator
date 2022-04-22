<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Model\Context\BufferBuilder;
use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ClassNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PhpFileNameGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use function array_merge;

class EntityClassSequence extends Sequence
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
        parent::__construct(
            array_merge([
                $globalFactory->create(PathGenerator::class),
                $globalFactory->create(PhpFileNameGenerator::class),
                $globalFactory->create(NamespaceGenerator::class),
                $globalFactory->create(ClassNameGenerator::class),
                $globalFactory->create(DataObjectExtendsGenerator::class),
                $globalFactory->create(PropertiesGenerator::class),
                $globalFactory->create(MethodGenerator::class),
                $globalFactory->create(EntityStubGenerator::class),
                $globalFactory->create(Writer::class),
            ], $sequences)
        );
    }
}
