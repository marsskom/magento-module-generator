<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Translator;

interface TranslatorInterface
{
    /**
     * Returns file name with extension.
     *
     * @param array $input
     *
     * @return string
     */
    public function getFileName(array $input): string;

    /**
     * Returns stub name.
     *
     * @param array $input
     *
     * @return string
     */
    public function getStubName(array $input): string;

    /**
     * "Translates" input into variables array.
     *
     * @param array $input
     *
     * @return array
     */
    public function translate(array $input): array;
}
