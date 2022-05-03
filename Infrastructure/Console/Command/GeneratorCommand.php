<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Console\Command;

use Exception;
use Magento\Framework\Console\Cli;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Domain\Scope\Input;
use Marsskom\Generator\Domain\Scope\ScopeBuilder;
use Marsskom\Generator\Infrastructure\Api\Data\FlowFactoryInterface;
use Marsskom\Generator\Infrastructure\Model\Context\ArrayRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class GeneratorCommand extends Command
{
    protected FlowFactoryInterface $flowFactory;

    private ScopeBuilder $scopeBuilder;

    /**
     * Command constructor.
     *
     * @param FlowFactoryInterface $flowFactory
     * @param ScopeBuilder         $scopeBuilder
     * @param string|null          $name
     */
    public function __construct(
        FlowFactoryInterface $flowFactory,
        ScopeBuilder $scopeBuilder,
        string $name = null
    ) {
        parent::__construct($name);

        $this->flowFactory = $flowFactory;
        $this->scopeBuilder = $scopeBuilder;
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
            $this->flow()->run($scope);
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
