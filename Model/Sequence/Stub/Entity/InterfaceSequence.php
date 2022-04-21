<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameChanger;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathPrefixAssigner;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use function array_merge;

class InterfaceSequence extends Sequence
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
            $globalFactory->create(PathPrefixAssigner::class, [
                'prefix' => 'Api/Data',
            ]),
            $globalFactory->create(FileNameChanger::class, [
                'suffix' => 'Interface',
            ]),
            $globalFactory->create(NamespaceGenerator::class),
            $globalFactory->create(InterfaceStubGenerator::class),
            $globalFactory->create(Writer::class),
        ], $sequences));
    }
}
