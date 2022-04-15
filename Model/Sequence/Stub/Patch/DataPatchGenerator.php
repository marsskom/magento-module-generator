<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Patch;

use Marsskom\Generator\Model\Foundation\StubGenerator;

class DataPatchGenerator extends StubGenerator
{
    /**
     * @inheritdoc
     */
    public function getStubName(): string
    {
        return 'patch/data_patch.stub';
    }
}
