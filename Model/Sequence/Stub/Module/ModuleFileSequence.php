<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Module;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameAssignerFactory;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathAssignerFactory;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ModuleNameGenerator;

class ModuleFileSequence extends Sequence
{
    /**
     * @inheritdoc
     */
    public function __construct(
        ModuleNameGenerator $moduleName,
        PathAssignerFactory $pathFactory,
        FileNameAssignerFactory $fileNameFactory,
        ModuleFileGenerator $moduleFile,
        Writer $writer,
        array $sequences = []
    ) {
        parent::__construct(array_merge([
            $moduleName,
            $pathFactory->create([
                'path'       => 'etc',
                'isAbsolute' => true,
            ]),
            $fileNameFactory->create([
                'name' => 'module.xml',
            ]),
            $moduleFile,
            $writer,
        ], $sequences));
    }
}
