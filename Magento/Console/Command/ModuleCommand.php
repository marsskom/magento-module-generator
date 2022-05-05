<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Console\Command;

use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;
use Marsskom\Generator\Infrastructure\Model\Filesystem\FileName;
use Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache\Param;
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
            ->with('default', [
                $moduleNameCallable,
                static fn($c) => $c->set(ContextVariable::FILENAME_VALUE, new FileName('registration.php')),
                static fn($c) => $c->set(
                    ContextVariable::BOUNDED_VALUE,
                    new Param('module/registration.stub', $c->getAll())
                ),
            ])
            ->with('module', [
                $moduleNameCallable,
                static fn($c) => $c->set(ContextVariable::FILENAME_VALUE, new FileName('etc/module.xml')),
                static fn($c) => $c->set(
                    ContextVariable::BOUNDED_VALUE,
                    new Param('module/module.stub', $c->getAll())
                ),
            ]);
    }
}
