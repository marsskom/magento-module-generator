<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Api\Data\CoordinatorInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GeneratorCommand extends Command
{
    protected CoordinatorInterface $coordinator;

    protected TranslatorInterface $translator;

    protected SequenceInterface $sequence;

    /**
     * Command constructor.
     *
     * @param CoordinatorInterface $coordinator
     * @param TranslatorInterface  $translator
     * @param SequenceInterface    $sequence
     * @param string|null          $name
     */
    public function __construct(
        CoordinatorInterface $coordinator,
        TranslatorInterface $translator,
        SequenceInterface $sequence,
        string $name = null
    ) {
        parent::__construct($name);

        $this->coordinator = $coordinator;
        $this->translator = $translator;
        $this->sequence = $sequence;
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
                    'Setup/Patch/Data'
                ),
            ],
            $this->optionsList(),
        );
    }

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
        try {
            $coordinator = $this->coordinator
                ->setInput($input->getOptions())
                ->setTranslator($this->translator);

            $this->sequence->execute($coordinator->getContext());
        } catch (LocalizedException $exception) {
            $output->writeln($exception->getMessage());

            $output->writeln($exception->getTraceAsString());

            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }
}
