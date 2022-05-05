<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Console\Command;

use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;
use Marsskom\Generator\Infrastructure\Model\Filesystem\FileName;
use Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache\Param;
use Marsskom\Generator\Magento\Model\Callables\NamespaceCallable;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Validator\ModuleValidator;
use Marsskom\Generator\Magento\Model\Validator\NameValidator;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use function rtrim;

class ConsoleCommand extends GeneratorCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:console:command');
        $this->setDescription("Generates console command class.");

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
            new InputOption(
                InputParameter::PATH,
                null,
                InputOption::VALUE_OPTIONAL,
                'File location',
                'Console/Command'
            ),
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
            new InputOption(
                'cname',
                null,
                InputOption::VALUE_OPTIONAL,
                'Command name',
                ''
            ),
            new InputOption(
                'cdesc',
                null,
                InputOption::VALUE_OPTIONAL,
                'Command description',
                ''
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function flow(): FlowInterface
    {
        return $this->flowFactory
            ->create()
            ->validator([
                new ModuleValidator(),
                new NameValidator(),
            ])
            ->with('default', [
                static fn($c, $i) => $c->set(TemplateVariable::MODULE_NAME, $i->get(InputParameter::MODULE))
                                       ->set(TemplateVariable::CLASS_NAME, $i->get(InputParameter::NAME))
                                       ->set('command_name', $i->get('cname'))
                                       ->set('command_description', $i->get('cdesc')),
                new NamespaceCallable(),
                static fn($c, $i) => $c->set(ContextVariable::FILENAME_VALUE, new FileName(
                    '%path%/%name%.php',
                    [
                        '%path%' => rtrim($i->get(InputParameter::PATH), '/'),
                        '%name%' => $i->get(InputParameter::NAME),
                    ]
                )),
                static fn($c, $i) => $c->set(
                    ContextVariable::BOUNDED_VALUE,
                    new Param('console/command.stub', $c->getAll())
                ),
            ]);
    }
}
