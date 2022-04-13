<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;
use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Api\Data\CoordinatorInterfaceFactory;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Model\Context\Parameters;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GeneratorCommand extends Command
{
    protected SequenceInterface $sequence;

    protected CoordinatorInterfaceFactory $coordinatorFactory;

    /**
     * @var InputTranslatorInterface[]
     */
    protected array $inputTranslators;

    /**
     * Generator command constructor.
     *
     * @param SequenceInterface           $sequence
     * @param CoordinatorInterfaceFactory $coordinatorFactory
     * @param InputTranslatorInterface[]  $inputTranslators
     * @param string|null                 $name
     */
    public function __construct(
        SequenceInterface $sequence,
        CoordinatorInterfaceFactory $coordinatorFactory,
        array $inputTranslators = [],
        string $name = null
    ) {
        parent::__construct($name);

        $this->sequence = $sequence;
        $this->coordinatorFactory = $coordinatorFactory;
        $this->inputTranslators = $inputTranslators;
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
                    Parameters::MODULE,
                    null,
                    InputOption::VALUE_REQUIRED,
                    'Module name (Vendor_Module)'
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
            $this->sequence->execute($this->getContext($input));
        } catch (LocalizedException $exception) {
            $output->writeln($exception->getMessage());

            $output->writeln($exception->getTraceAsString());

            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }

    /**
     * Creates context.
     *
     * @param InputInterface $input
     *
     * @return ContextInterface
     */
    protected function getContext(InputInterface $input): ContextInterface
    {
        $coordinator = $this->coordinatorFactory->create([
            'inputOptions'     => $input->getOptions(),
            'inputTranslators' => $this->inputTranslators,
        ]);

        $coordinator->create();

        return $coordinator->get();
    }
}
