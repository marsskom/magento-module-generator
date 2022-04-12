<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Context\InputInterface;

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
     * Adds translators.
     *
     * @param array $translators
     *
     * @return TranslatorInterface
     */
    public function addTranslators(array $translators): TranslatorInterface;
}
