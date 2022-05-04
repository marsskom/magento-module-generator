<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Console\Command;

use Marsskom\Generator\Domain\Exception\Pipeline\ConditionFailedException;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;
use Marsskom\Generator\Infrastructure\Model\Filesystem\FileName;
use Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache\Param;
use Marsskom\Generator\Magento\Model\Callables\NamespaceCallable;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\Helper\Callables\NameHelper;
use Marsskom\Generator\Magento\Model\Validator\ModuleValidator;
use Marsskom\Generator\Magento\Model\Validator\NameValidator;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class CronCommand extends GeneratorCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:cron');
        $this->setDescription("Generates cronjob.");

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
                'Cron class location',
                'Cron'
            ),
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Cronjob name (example - "export_products")'
            ),
            new InputOption(
                'group',
                null,
                InputOption::VALUE_OPTIONAL,
                'Cronjob group (example - "export")',
                'default'
            ),
            new InputOption(
                'schedule',
                null,
                InputOption::VALUE_OPTIONAL,
                'Cronjob schedule (example - "*/5 * * * *")',
                '*/5 * * * *'
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function flow(): FlowInterface
    {
        $defaultPipeline = static fn($c, $i) => $c
            ->set(TemplateVariable::MODULE_NAME, $i->get(InputParameter::MODULE))
            ->set(TemplateVariable::CLASS_NAME, $i->get(InputParameter::NAME));

        $cronPipeline = static fn($c, $i) => $c
            ->set('cronjob_group', $i->get('group'))
            ->set('cronjob_name', $i->get(InputParameter::NAME))
            ->set('cronjob_class', $c->get(TemplateVariable::FILE_NAMESPACE)
                . '\\'
                . $c->get(TemplateVariable::CLASS_NAME))
            ->set('cronjob_schedule', $i->get('schedule'));

        return $this->flowFactory
            ->create()
            ->validator([
                new ModuleValidator(),
                new NameValidator(),
            ])
            ->with('default', [
                new NamespaceCallable(),
                $defaultPipeline,
                static fn($c, $i) => $c
                    ->set(TemplateVariable::CLASS_NAME, (new NameHelper())->id2Class($i->get(InputParameter::NAME)))
                    ->set(ContextVariable::FILENAME_VALUE, new FileName(
                        '%path%/%name%.php',
                        [
                            '%path%' => rtrim($i->get(InputParameter::PATH), '/'),
                            '%name%' => (new NameHelper())->id2Class($i->get(InputParameter::NAME)),
                        ]
                    )),
                static fn($c) => $c->set(
                    ContextVariable::BOUNDED_VALUE,
                    new Param('cron/class.stub', $c->getAll())
                ),
            ])
            ->with('crontab', [
                new NamespaceCallable(),
                $defaultPipeline,
                $cronPipeline,
                static fn($c) => $c->set(ContextVariable::FILENAME_VALUE, new FileName('etc/crontab.xml')),
                static fn($c) => $c->set(
                    ContextVariable::BOUNDED_VALUE,
                    new Param('cron/crontab.stub', $c->getAll())
                ),
            ])
            ->with('group', [
                [
                    // Condition
                    static function ($i): void {
                        if ('default' === $i->get('group')) {
                            throw new ConditionFailedException("Group is default.");
                        }
                    },
                    new NamespaceCallable(),
                    $defaultPipeline,
                    $cronPipeline,
                    static fn($c, $i) => $c->set('cronjob_group', $i->get('group')),
                    static fn($c) => $c->set(ContextVariable::FILENAME_VALUE, new FileName('etc/cron_groups.xml')),
                    static fn($c) => $c->set(
                        ContextVariable::BOUNDED_VALUE,
                        new Param('cron/cron_groups.stub', $c->getAll())
                    ),
                ],
            ]);
    }
}
