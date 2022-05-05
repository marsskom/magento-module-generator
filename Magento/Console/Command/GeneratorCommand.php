<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Console\Command;

use Exception;
use Magento\Framework\Console\Cli;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Domain\Scope\Input;
use Marsskom\Generator\Domain\Scope\ScopeBuilder;
use Marsskom\Generator\Infrastructure\Api\Data\FlowFactoryInterface;
use Marsskom\Generator\Infrastructure\Model\Context\ArrayRepository;
use Marsskom\Generator\Magento\Model\Observer\OutputAskObserver;
use Marsskom\Generator\Magento\Model\Observer\OutputErrorObserver;
use Marsskom\Generator\Magento\Model\Observer\OutputInfoObserver;
use Marsskom\Generator\Magento\Model\Writer\Mustache\ScopeWriter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GeneratorCommand extends Command
{
    protected FlowFactoryInterface $flowFactory;

    private ScopeBuilder $scopeBuilder;

    private ScopeWriter $scopeWriter;

    /**
     * Command constructor.
     *
     * @param FlowFactoryInterface $flowFactory
     * @param ScopeBuilder         $scopeBuilder
     * @param ScopeWriter          $scopeWriter
     * @param string|null          $name
     */
    public function __construct(
        FlowFactoryInterface $flowFactory,
        ScopeBuilder $scopeBuilder,
        ScopeWriter $scopeWriter,
        string $name = null
    ) {
        parent::__construct($name);

        $this->flowFactory = $flowFactory;
        $this->scopeBuilder = $scopeBuilder;
        $this->scopeWriter = $scopeWriter;
    }

    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setDefinition($this->definition());

        parent::configure();
    }

    /**
     * Returns command definition.
     *
     * @return InputDefinition
     */
    abstract protected function definition(): InputDefinition;

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $scope = $this->scopeBuilder->build(new ArrayRepository(), new Input($input->getOptions()));

        try {
            $scope = $this->flow()->run($scope);

            /** @var $scopeWriter ScopeWriter */
            $scopeWriter = $this->scopeWriter
                ->attach(
                    ScopeWriter::OUTPUT_ASK_EVENT,
                    new OutputAskObserver($input, $output)
                )
                ->attach(ScopeWriter::OUTPUT_INFO_EVENT, new OutputInfoObserver($output))
                ->attach(ScopeWriter::OUTPUT_ERROR_EVENT, new OutputErrorObserver($output));

            $scopeWriter->execute($scope);
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());

            return Cli::RETURN_FAILURE;
        }

        return Cli::RETURN_SUCCESS;
    }

    /**
     * Returns flow.
     *
     * @return FlowInterface
     */
    abstract protected function flow(): FlowInterface;
}
