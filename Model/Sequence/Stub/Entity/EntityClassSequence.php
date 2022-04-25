<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Context\ContextUsageGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ClassNameGenerator;
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
                $globalFactory->create(ContextUsageGenerator::class, [
                    'contextAlias' => ScopeInterface::DEFAULT_CONTEXT,
                ]),
                $globalFactory->create(NamespaceGenerator::class),
                $globalFactory->create(ClassNameGenerator::class),
                $globalFactory->create(DataObjectExtendsGenerator::class),
                $globalFactory->create(PropertiesGenerator::class),
                $globalFactory->create(MethodGenerator::class),
                $globalFactory->create(EntityStubGenerator::class),
            ], $sequences)
        );
    }
}
