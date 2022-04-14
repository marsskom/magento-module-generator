<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Translator\Php\Patch;

use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Helper\Translator\NamespaceModel;
use Marsskom\Generator\Model\Translator\Php\PhpTranslator;

class DataPatchTranslator extends PhpTranslator
{
    private NamespaceModel $namespace;

    /**
     * Data patch translator constructor.
     *
     * @param NamespaceModel $namespace
     */
    public function __construct(
        NamespaceModel $namespace
    ) {
        $this->namespace = $namespace;
    }

    /**
     * @inheritdoc
     */
    public function getStubName(array $input): string
    {
        return 'patch/data_patch.stub';
    }

    /**
     * @inheritdoc
     */
    public function translate(array $input): array
    {
        return [
            TemplateVariable::FILE_NAMESPACE => $this->namespace->getNamespace(
                $input[InputParameter::MODULE],
                $input[InputParameter::PATH]
            ),
            TemplateVariable::CLASS_NAME     => $input[InputParameter::NAME],
        ];
    }
}
