<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Model\Foundation\StubGenerator;

class InterfaceStubGenerator extends StubGenerator
{
    /**
     * @inheritdoc
     */
    public function getStubName(): string
    {
        return 'entity/interface.stub';
    }
}
