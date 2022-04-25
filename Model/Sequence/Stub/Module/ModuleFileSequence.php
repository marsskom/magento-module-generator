<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Module;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Context\ContextUsageGenerator;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ModuleNameGenerator;

class ModuleFileSequence extends Sequence
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
            $globalFactory->create(ContextUsageGenerator::class, [
                'contextAlias' => 'module.xml',
            ]),
            $globalFactory->create(ModuleNameGenerator::class),
            $globalFactory->create(ModuleFileStubGenerator::class),
            $globalFactory->create(Writer::class),
        ], $sequences));
    }
}
