<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Api\Data\ComponentManagerInterface;
use Marsskom\Generator\Model\Scope\ScopeBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GeneratorCommand extends Command
{
    protected ComponentManagerInterface $componentManager;

    protected ScopeBuilder $scopeBuilder;

    /**
     * Command constructor.
     *
     * @param ComponentManagerInterface $componentManager
     * @param ScopeBuilder              $scopeBuilder
     * @param string|null               $name
     */
    public function __construct(
        ComponentManagerInterface $componentManager,
        ScopeBuilder $scopeBuilder,
        string $name = null
    ) {
        $this->componentManager = $componentManager;
        $this->scopeBuilder = $scopeBuilder;

        parent::__construct($name);
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setDefinition($this->componentManager->inputDefinition());

        parent::configure();
    }

    /**
     * Returns event name.
     *
     * @return string
     */
    abstract protected function getEventName(): string;

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->validate($input, $output)) {
            return Cli::RETURN_FAILURE;
        }

        try {
            $this->componentManager->sequence()->execute(
                $this->scopeBuilder->create($input, $output)
            );
        } catch (LocalizedException $exception) {
            $output->writeln($exception->getMessage());

            $output->writeln($exception->getTraceAsString());

            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }

    /**
     * Validates input params.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function validate(InputInterface $input, OutputInterface $output): bool
    {
        $validateResult = $this->componentManager
            ->validationObserver()
            ->notify(
                $this->getEventName(),
                $input->getOptions()
            );

        if (!$validateResult->isValid()) {
            $output->writeln($validateResult->getMessage());
        }

        return $validateResult->isValid();
    }
}
