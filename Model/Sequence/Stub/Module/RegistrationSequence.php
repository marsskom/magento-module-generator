<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Module;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Model\Sequence\Automation\Writer;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameAssignerFactory;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\ModuleNameGenerator;

class RegistrationSequence extends Sequence
{
    /**
     * @inheritdoc
     */
    public function __construct(
        ModuleNameGenerator $moduleName,
        PathGenerator $path,
        FileNameAssignerFactory $fileNameFactory,
        RegistrationGenerator $registration,
        Writer $writer,
        array $sequences = []
    ) {
        parent::__construct(array_merge([
            $path,
            $moduleName,
            $fileNameFactory->create([
                'name' => 'registration.php',
            ]),
            $registration,
            $writer,
        ], $sequences));
    }
}
