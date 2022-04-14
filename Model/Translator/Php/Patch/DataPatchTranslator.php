<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Translator\Php\Patch;

use Marsskom\Generator\Model\Automation\NamespaceModel;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Helper\Path;
use Marsskom\Generator\Model\Stub\ClassStubFactory;
use Marsskom\Generator\Model\Stub\FileFactory;
use Marsskom\Generator\Model\Translator\Php\PhpTranslator;

class DataPatchTranslator extends PhpTranslator
{
    private FileFactory $fileFactory;

    private ClassStubFactory $classStubFactory;

    private NamespaceModel $namespace;

    /**
     * Php translator constructor.
     *
     * @param Path             $pathHelper
     * @param FileFactory      $fileFactory
     * @param ClassStubFactory $classStubFactory
     * @param NamespaceModel   $namespace
     */
    public function __construct(
        Path $pathHelper,
        FileFactory $fileFactory,
        ClassStubFactory $classStubFactory,
        NamespaceModel $namespace
    ) {
        parent::__construct($pathHelper);

        $this->fileFactory = $fileFactory;
        $this->classStubFactory = $classStubFactory;
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
            $this->fileFactory->create([
                'namespace'  => $this->namespace->getNamespace(
                    $input[InputParameter::MODULE],
                    $input[InputParameter::PATH]
                ),
                'annotation' => '',
                'uses'       => [],
            ]),
            $this->classStubFactory->create([
                'name'       => $input[InputParameter::NAME],
                'annotation' => '',
            ]),
        ];
    }
}
