<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Api\Data\Validator\ValidationObserverInterface;
use Marsskom\Generator\Model\Context\ContextBuilder;
use Marsskom\Generator\Model\Enum\InputParameter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GeneratorCommand extends Command
{
    protected SequenceInterface $sequence;

    protected ValidationObserverInterface $validationObserver;

    protected ContextBuilder $contextBuilder;

    /**
     * Command constructor.
     *
     * @param SequenceInterface           $sequence
     * @param ValidationObserverInterface $validationObserver
     * @param ContextBuilder              $contextBuilder
     * @param string|null                 $name
     */
    public function __construct(
        SequenceInterface $sequence,
        ValidationObserverInterface $validationObserver,
        ContextBuilder $contextBuilder,
        string $name = null
    ) {
        parent::__construct($name);

        $this->sequence = $sequence;
        $this->validationObserver = $validationObserver;
        $this->contextBuilder = $contextBuilder;
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setDefinition($this->getOptionsList());

        parent::configure();
    }

    /**
     * Returns options list.
     *
     * @return array
     */
    protected function getOptionsList(): array
    {
        return array_merge(
            [
                new InputOption(
                    InputParameter::MODULE,
                    null,
                    InputOption::VALUE_REQUIRED,
                    'Module name (Vendor_Module)'
                ),
                new InputOption(
                    InputParameter::PATH,
                    null,
                    InputOption::VALUE_OPTIONAL,
                    'File location',
                    $this->getDefaultPathParam()
                ),
            ],
            $this->optionsList(),
        );
    }

    /**
     * Returns event name.
     *
     * @return string
     */
    abstract protected function getEventName(): string;

    /**
     * Returns path to directory where file(s) will be created.
     *
     * @return string
     */
    abstract protected function getDefaultPathParam(): string;

    /**
     * Returns specific command options list.
     *
     * @return array
     */
    abstract protected function optionsList(): array;

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$this->validate($input, $output)) {
            return Cli::RETURN_FAILURE;
        }

        try {
            $this->sequence->execute(
                $this->contextBuilder->create($input, $output)
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
        $validateResult = $this->validationObserver->notify(
            $this->getEventName(),
            $input->getOptions()
        );

        if (!$validateResult->isValid()) {
            $output->writeln($validateResult->getMessage());
        }

        return $validateResult->isValid();
    }
}
