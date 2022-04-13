<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Heap\Command\DataPatch;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Model\Helper\UseModelFactory;
use Marsskom\Generator\Model\Php\Foundation\AbstractSequence;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use function array_shift;

class FileGenerator extends AbstractSequence
{
    private UseModelFactory $useFactory;

    /**
     * @inheritdoc
     *
     * @param UseModelFactory $useFactory
     */
    public function __construct(
        UseModelFactory $useFactory,
        array $sequences = [],
        array $nextMiddlewares = []
    ) {
        parent::__construct($sequences, $nextMiddlewares);

        $this->useFactory = $useFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        /** @var $phpFile PhpFile */
        $phpFile = $context->output()->getState();

        $namespaces = $phpFile->getNamespaces();
        $fileNamespace = array_shift($namespaces);

        foreach ($this->getUses() as $use) {
            $fileNamespace->addUse($use->getName(), $use->getAlias(), $use->getType());
        }

        $context->output()->setState($phpFile);

        return $context;
    }

    /**
     * Returns uses.
     *
     * @return array
     */
    protected function getUses(): array
    {
        return [
            $this->useFactory->create([
                'name' => DataPatchInterface::class,
                'type' => PhpNamespace::NameNormal,
            ]),
            $this->useFactory->create([
                'name' => ModuleDataSetupInterface::class,
                'type' => PhpNamespace::NameNormal,
            ]),
        ];
    }
}
