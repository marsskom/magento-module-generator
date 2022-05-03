<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Console\Command;

use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Infrastructure\Console\Command\GeneratorCommand;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Validator\ModuleValidator;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class ModuleCommand extends GeneratorCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:module');
        $this->setDescription("Generates module.");

        parent::configure();
    }

    /**
     * @inheritdoc
     */
    protected function definition(): InputDefinition
    {
        return new InputDefinition([
            new InputOption(
                InputParameter::MODULE,
                null,
                InputOption::VALUE_REQUIRED,
                'Module name (Vendor_Module)'
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function flow(): FlowInterface
    {
        $moduleNameCallable = static fn($c, $i) => $c->set(
            TemplateVariable::MODULE_NAME,
            $i->get(InputParameter::MODULE)
        );

        return $this->flowFactory
            ->create()
            ->validator(new ModuleValidator())
            ->with('default', [$moduleNameCallable])
            ->with('module', [$moduleNameCallable]);
    }
}
