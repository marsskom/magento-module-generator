<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Console;

use Marsskom\Generator\Model\Foundation\StubGenerator;

class CommandStubGenerator extends StubGenerator
{
    /**
     * @inheritdoc
     */
    public function getStubName(): string
    {
        return 'console/command.stub';
    }
}
