<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Console\Command\EntityCommand;
use Marsskom\Generator\Model\Context\BufferBuilder;
use Marsskom\Generator\Model\Foundation\BufferedSequence;
use Marsskom\Generator\Model\GlobalFactory;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameChanger;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathPrefixAssigner;
use Marsskom\Generator\Model\Sequence\Stub\Automation\NamespaceGenerator;
use function array_merge;

class InterfaceSequence extends BufferedSequence
{
    /**
     * @inheritdoc
     *
     * @param GlobalFactory $globalFactory
     */
    public function __construct(
        GlobalFactory $globalFactory,
        BufferBuilder $bufferBuilder,
        array $sequences = []
    ) {
        parent::__construct(
            $bufferBuilder,
            array_merge([
                $globalFactory->create(PathPrefixAssigner::class, [
                    'prefix' => 'Api/Data',
                ]),
                $globalFactory->create(FileNameChanger::class, [
                    'suffix' => 'Interface',
                ]),
                $globalFactory->create(NamespaceGenerator::class),
                $globalFactory->create(PropertiesGenerator::class),
                $globalFactory->create(MethodGenerator::class),
                $globalFactory->create(InterfaceGenerator::class),
                $globalFactory->create(InterfaceStubGenerator::class),
                $globalFactory->create(Writer::class),
            ], $sequences)
        );
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        if (empty($scope->input()->get(EntityCommand::COMMAND_HAS_INTERFACE_PARAMETER))) {
            return $scope;
        }

        return parent::execute($scope);
    }
}
