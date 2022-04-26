<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console;

use Magento\Framework\Phrase;
use Marsskom\Generator\Api\Data\Command\InterruptInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class Interrupt implements InterruptInterface
{
    private InputInterface $input;

    private OutputInterface $output;

    /**
     * Interrupt constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output
    ) {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @inheritdoc
     */
    public function ask(Phrase $question): bool
    {
        return (new QuestionHelper())
            ->ask($this->input, $this->output, new ConfirmationQuestion((string) $question));
    }

    /**
     * @inheritdoc
     */
    public function info(Phrase $information): void
    {
        $this->output->writeln((string) $information);
    }

    /**
     * @inheritdoc
     */
    public function choose(Phrase $question, array $choices, $default = null): string
    {
        $choiceQuestion = new ChoiceQuestion(
            (string) $question,
            $choices,
            $default
        );

        return (new QuestionHelper())
            ->ask($this->input, $this->output, $choiceQuestion);
    }
}
