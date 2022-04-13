<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console\Command;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;
use Marsskom\Generator\Helper\Translator\NamespaceHelper;
use Marsskom\Generator\Model\Context\InputFactory;
use Marsskom\Generator\Model\Helper\UseModelFactory;
use Nette\PhpGenerator\PhpNamespace;

class DataPatchTranslator implements InputTranslatorInterface
{
    private NamespaceHelper $namespaceHelper;

    private UseModelFactory $useFactory;

    /**
     * Module translator constructor.
     *
     * @param NamespaceHelper $namespaceHelper
     * @param UseModelFactory $useFactory
     */
    public function __construct(
        NamespaceHelper $namespaceHelper,
        UseModelFactory $useFactory
    ) {
        $this->namespaceHelper = $namespaceHelper;
        $this->useFactory = $useFactory;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function translate(array $contexts, array $inputOptions): array
    {
        return [
            'file'  => [
                'namespace' => $this->namespaceHelper->getNamespace($inputOptions['module'], $inputOptions['path']),
                'uses'      => [
                    $this->useFactory->create([
                        'name' => \Magento\Framework\Setup\Patch\DataPatchInterface::class,
                        'type' => PhpNamespace::NameNormal,
                    ]),
                ],
            ],
            'class' => [
                'extends'    => '',
                'implements' => [
                    'DataPatchInterface',
                ],
                'comments'   => [],
            ],
        ];
    }
}
