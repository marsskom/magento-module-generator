<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Console\InterruptFactory;
use Marsskom\Generator\Model\Context\ContextFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ContextBuilder
{
    protected ContextFactory $contextFactory;

    protected InterruptFactory $interruptFactory;

    /**
     * Context builder constructor.
     *
     * @param ContextFactory   $contextFactory
     * @param InterruptFactory $interruptFactory
     */
    public function __construct(
        ContextFactory $contextFactory,
        InterruptFactory $interruptFactory
    ) {
        $this->contextFactory = $contextFactory;
        $this->interruptFactory = $interruptFactory;
    }

    /**
     * Creates context.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return ContextInterface
     */
    public function create(InputInterface $input, OutputInterface $output): ContextInterface
    {
        $interrupt = $this->interruptFactory->create([
            'input'  => $input,
            'output' => $output,
        ]);

        return $this->contextFactory->create([
            'userInput' => $input->getOptions(),
            'interrupt' => $interrupt,
        ]);
    }
}
