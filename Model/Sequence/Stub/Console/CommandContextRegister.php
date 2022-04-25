<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Console;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Sequence\Automation\Context\ContextRegister;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PathGenerator;
use Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem\PhpFileNameGenerator;

class CommandContextRegister extends ContextRegister
{
    /**
     * @inheritdoc
     */
    public function getContexts(): array
    {
        return [
            ScopeInterface::DEFAULT_CONTEXT => [
                $this->globalFactory->create(PathGenerator::class),
                $this->globalFactory->create(PhpFileNameGenerator::class),
            ],
        ];
    }
}
