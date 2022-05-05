<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Observer;

use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Marsskom\Generator\Magento\Model\InputQuestion\Writer\FileExistsActionQuestion;
use Marsskom\Generator\Magento\Model\Writer\Mustache\ScopeWriter;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class OutputAskObserver implements ObserverInterface
{
    private InputInterface $input;

    private OutputInterface $output;

    /**
     * Output ask observer constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @inheritdoc
     */
    public function receive(SubjectInterface $subject, string $eventName, ValueObjectInterface $payload): void
    {
        /** @var $subject ScopeWriter */
        /** @var $question FileExistsActionQuestion */

        $question = $payload->value();
        $choiceQuestion = new ChoiceQuestion(
            (string) $question->getQuestion(),
            $question->getChoices(),
            $question->getDefault()
        );

        $subject->setVariant(
            (new QuestionHelper())->ask($this->input, $this->output, $choiceQuestion)
        );
    }
}
