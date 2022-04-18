<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Module;

use Marsskom\Generator\Model\Foundation\Sequence;

class ModuleSequence extends Sequence
{
    /**
     * @inheritdoc
     */
    public function __construct(
        RegistrationSequence $registrationSequence,
        ModuleFileSequence $moduleFileSequence,
        array $sequences = []
    ) {
        parent::__construct(array_merge([
            $registrationSequence,
            $moduleFileSequence,
        ], $sequences));
    }
}
