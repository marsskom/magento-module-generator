<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Translator\Php;

use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Helper\Path;
use Marsskom\Generator\Model\Stub\ClassStubFactory;
use Marsskom\Generator\Model\Stub\FileFactory;
use Marsskom\Generator\Model\Translator\AbstractTranslator;

class PhpTranslator extends AbstractTranslator
{
    private FileFactory $fileFactory;

    private ClassStubFactory $classStubFactory;

    /**
     * Php translator constructor.
     *
     * @param Path             $pathHelper
     * @param FileFactory      $fileFactory
     * @param ClassStubFactory $classStubFactory
     */
    public function __construct(
        Path $pathHelper,
        FileFactory $fileFactory,
        ClassStubFactory $classStubFactory
    ) {
        parent::__construct($pathHelper);

        $this->fileFactory = $fileFactory;
        $this->classStubFactory = $classStubFactory;
    }

    /**
     * @inheritdoc
     */
    public function getFileName(array $input): string
    {
        return parent::getFileName($input) . '.php';
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
                'namespace'  => '',
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
