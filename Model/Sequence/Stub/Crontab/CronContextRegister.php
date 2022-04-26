<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Crontab;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\InputOption\NameClosures;
use Marsskom\Generator\Model\Sequence\Automation\Context\ContextRegister;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameAssigner;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\FileNameChanger;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathAssigner;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;

class CronContextRegister extends ContextRegister
{
    /**
     * @inheritdoc
     */
    public function getContexts(): array
    {
        return [
            ScopeInterface::DEFAULT_CONTEXT => [
                $this->globalFactory->create(PathGenerator::class),
                $this->globalFactory->create(FileNameChanger::class, [
                    'callback' => [NameClosures::class, 'idNameToClassName'],
                ]),
            ],
            'crontab'                       => [
                $this->globalFactory->create(PathAssigner::class, [
                    'path' => 'etc',
                ]),
                $this->globalFactory->create(FileNameAssigner::class, [
                    'name' => 'crontab.xml',
                ]),
            ],
            'group'                         => [
                $this->globalFactory->create(PathAssigner::class, [
                    'path' => 'etc',
                ]),
                $this->globalFactory->create(FileNameAssigner::class, [
                    'name' => 'cron_groups.xml',
                ]),
            ],

        ];
    }
}
