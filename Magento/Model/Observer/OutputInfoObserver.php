<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Model\Observer;

use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;
use Marsskom\Generator\Domain\Interfaces\Observer\SubjectInterface;
use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use Symfony\Component\Console\Output\OutputInterface;

class OutputInfoObserver implements ObserverInterface
{
    private OutputInterface $output;

    /**
     * Output info observer constructor.
     *
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @inheritdoc
     */
    public function receive(SubjectInterface $subject, string $eventName, ValueObjectInterface $payload): void
    {
        $this->output->writeln('<info>' . $payload->value() . '</info>');
    }
}
