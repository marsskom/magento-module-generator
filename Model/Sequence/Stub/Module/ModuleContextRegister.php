<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Module;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Sequence\Automation\Context\ContextRegister;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameAssigner;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathAssigner;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;

class ModuleContextRegister extends ContextRegister
{
    /**
     * @inheritdoc
     */
    public function getContexts(): array
    {
        return [
            ScopeInterface::DEFAULT_CONTEXT => [
                $this->globalFactory->create(PathGenerator::class),
                $this->globalFactory->create(FileNameAssigner::class, [
                    'name' => 'registration.php',
                ]),
            ],
            'module.xml'                    => [
                $this->globalFactory->create(PathAssigner::class, [
                    'path'       => 'etc',
                    'isAbsolute' => true,
                ]),
                $this->globalFactory->create(FileNameAssigner::class, [
                    'name' => 'module.xml',
                ]),
            ],
        ];
    }
}
