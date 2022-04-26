<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Command;

use Magento\Framework\Phrase;

interface InterruptInterface
{
    /**
     * Interrupts stream and ask for confirmation.
     *
     * @param Phrase $question
     *
     * @return bool
     */
    public function ask(Phrase $question): bool;

    /**
     * Sends information message into output.
     *
     * @param Phrase $information
     *
     * @return void
     */
    public function info(Phrase $information): void;

    /**
     * Sends choose question and interrupts stream for user answer.
     *
     * @param Phrase $question
     * @param array  $choices
     * @param mixed  $default
     *
     * @return string
     */
    public function choose(Phrase $question, array $choices, $default = null): string;
}
