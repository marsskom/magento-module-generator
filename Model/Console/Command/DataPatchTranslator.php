<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console\Command;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;
use Marsskom\Generator\Helper\Translator\NamespaceHelper;
use Marsskom\Generator\Helper\Translator\PathHelper;
use Marsskom\Generator\Model\Context\InputFactory;
use Marsskom\Generator\Model\Helper\UseModelFactory;
use Nette\PhpGenerator\PhpNamespace;

class DataPatchTranslator implements InputTranslatorInterface
{
    private PathHelper $pathHelper;

    private NamespaceHelper $namespaceHelper;

    private UseModelFactory $useFactory;

    private string $defaultPath;

    /**
     * Module translator constructor.
     *
     * @param PathHelper      $pathHelper
     * @param NamespaceHelper $namespaceHelper
     * @param UseModelFactory $useFactory
     * @param string          $defaultPath
     */
    public function __construct(
        PathHelper $pathHelper,
        NamespaceHelper $namespaceHelper,
        UseModelFactory $useFactory,
        string $defaultPath = 'Setup/Patch/Data'
    ) {
        $this->pathHelper = $pathHelper;
        $this->namespaceHelper = $namespaceHelper;
        $this->useFactory = $useFactory;
        $this->defaultPath = $defaultPath;
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
                'path'      => $this->pathHelper->getPathToFile(
                    $inputOptions['module'],
                    $this->defaultPath
                ),
                'namespace' => $this->namespaceHelper->getNamespace($inputOptions['module'], $this->defaultPath),
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
