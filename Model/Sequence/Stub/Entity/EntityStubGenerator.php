<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Entity;

use Marsskom\Generator\Model\Foundation\StubGenerator;

class EntityStubGenerator extends StubGenerator
{
    /**
     * @inheritdoc
     */
    public function getStubName(): string
    {
        return 'entity/entity.stub';
    }
}
