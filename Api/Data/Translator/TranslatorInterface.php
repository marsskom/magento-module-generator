<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Translator;

use Marsskom\Generator\Api\Data\StubInterface;

interface TranslatorInterface
{
    /**
     * Returns path to file.
     *
     * @param array $input
     *
     * @return string
     */
    public function getPath(array $input): string;

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
     * "Translates" input into stubs.
     *
     * @param array $input
     *
     * @return StubInterface[]
     */
    public function translate(array $input): array;
}
