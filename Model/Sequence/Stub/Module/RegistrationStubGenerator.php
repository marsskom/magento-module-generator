<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Module;

use Marsskom\Generator\Model\Foundation\StubGenerator;

class RegistrationStubGenerator extends StubGenerator
{
    /**
     * @inheritdoc
     */
    public function getStubName(): string
    {
        return 'module/registration.stub';
    }
}
