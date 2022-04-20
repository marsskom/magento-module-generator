<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Symfony\Component\Console\Input\InputDefinition;

interface ComponentManagerInterface
{
    /**
     * Returns input definition.
     *
     * @return InputDefinition
     */
    public function inputDefinition(): InputDefinition;

    /**
     * Returns validation observer.
     *
     * @return ValidationObserverInterface
     */
    public function validationObserver(): ValidationObserverInterface;

    /**
     * Returns sequence.
     *
     * @return SequenceInterface
     */
    public function sequence(): SequenceInterface;
}
