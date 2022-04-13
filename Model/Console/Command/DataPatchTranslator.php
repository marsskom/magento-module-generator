<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console\Command;

use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;
use Marsskom\Generator\Helper\Translator\NamespaceHelper;
use Marsskom\Generator\Model\Context\InputFactory;
use Marsskom\Generator\Model\Context\Parameters;

class DataPatchTranslator implements InputTranslatorInterface
{
    private NamespaceHelper $namespaceHelper;

    /**
     * Module translator constructor.
     *
     * @param NamespaceHelper $namespaceHelper
     */
    public function __construct(
        NamespaceHelper $namespaceHelper
    ) {
        $this->namespaceHelper = $namespaceHelper;
    }

    /**
     * @inheritdoc
     */
    public function translate(array $contexts, array $inputOptions): array
    {
        return [
            'file' => [
                'namespace' => $this->namespaceHelper->getNamespace(
                    $inputOptions[Parameters::MODULE],
                    $inputOptions[Parameters::PATH]
                ),
            ],
        ];
    }
}
