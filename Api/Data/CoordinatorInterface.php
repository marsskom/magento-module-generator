<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;

interface CoordinatorInterface
{
    /**
     * Sets user input.
     *
     * @param array $input
     *
     * @return CoordinatorInterface
     */
    public function setInput(array $input): CoordinatorInterface;

    /**
     * Sets translator.
     *
     * @param TranslatorInterface $translator
     *
     * @return CoordinatorInterface
     */
    public function setTranslator(TranslatorInterface $translator): CoordinatorInterface;

    /**
     * Returns context.
     *
     * @return ContextInterface
     */
    public function getContext(): ContextInterface;
}
