<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Context;

interface InputTranslatorInterface
{
    /**
     * "Translates" external data into context.
     *
     * @param array                 $contexts
     * @param array<string, string> $inputOptions
     *
     * @return array<string, array<string, mixed>>
     */
    public function translate(array $contexts, array $inputOptions): array;
}
