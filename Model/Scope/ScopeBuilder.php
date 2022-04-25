<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Marsskom\Generator\Api\Data\Scope\InputInterfaceFactory as ScopeInputFactory;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterfaceFactory;
use Marsskom\Generator\Model\Console\InterruptFactory;
use Marsskom\Generator\Model\Context\ContextFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScopeBuilder
{
    private ScopeInterfaceFactory $scopeFactory;

    private ContextFactory $contextFactory;

    private ScopeInputFactory $scopeInputFactory;

    private InterruptFactory $interruptFactory;

    /**
     * Context builder constructor.
     *
     * @param ScopeInterfaceFactory $scopeFactory
     * @param ContextFactory        $contextFactory
     * @param ScopeInputFactory     $scopeInputFactory
     * @param InterruptFactory      $interruptFactory
     */
    public function __construct(
        ScopeInterfaceFactory $scopeFactory,
        ContextFactory $contextFactory,
        ScopeInputFactory $scopeInputFactory,
        InterruptFactory $interruptFactory
    ) {
        $this->scopeFactory = $scopeFactory;
        $this->contextFactory = $contextFactory;
        $this->scopeInputFactory = $scopeInputFactory;
        $this->interruptFactory = $interruptFactory;
    }

    /**
     * Creates and returns scope.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return ScopeInterface
     */
    public function create(InputInterface $input, OutputInterface $output): ScopeInterface
    {
        return $this->scopeFactory->create([
            'context'   => $this->contextFactory->create(),
            'input'     => $this->scopeInputFactory->create([
                'userInput' => $input->getOptions(),
            ]),
            'interrupt' => $this->interruptFactory->create([
                'input'  => $input,
                'output' => $output,
            ]),
        ]);
    }
}
