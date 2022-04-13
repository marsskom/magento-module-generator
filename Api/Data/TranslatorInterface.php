<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Context\InputInterface;
use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;

interface TranslatorInterface
{
    /**
     * "Translates" external data into context.
     *
     * @param array<string, string> $inputOptions
     *
     * @return InputInterface
     */
    public function translate(array $inputOptions): InputInterface;

    /**
     * Adds input translators.
     *
     * @param InputTranslatorInterface[] $inputTranslators
     *
     * @return TranslatorInterface
     */
    public function addInputTranslators(array $inputTranslators): TranslatorInterface;
}
