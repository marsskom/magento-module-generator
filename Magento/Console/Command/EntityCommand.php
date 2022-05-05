<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Magento\Console\Command;

use Marsskom\Generator\Domain\Exception\Pipeline\ConditionFailedException;
use Marsskom\Generator\Domain\Interfaces\Context\ContextInterface;
use Marsskom\Generator\Domain\Interfaces\FlowInterface;
use Marsskom\Generator\Infrastructure\Model\Enum\ContextVariable;
use Marsskom\Generator\Infrastructure\Model\Filesystem\FileName;
use Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache\Param;
use Marsskom\Generator\Magento\Model\Callables\MethodCallable;
use Marsskom\Generator\Magento\Model\Callables\NamespaceCallable;
use Marsskom\Generator\Magento\Model\Callables\PropertiesCallable;
use Marsskom\Generator\Magento\Model\Enum\InputParameter;
use Marsskom\Generator\Magento\Model\Enum\TemplateVariable;
use Marsskom\Generator\Magento\Model\InputOption\PropertiesOption;
use Marsskom\Generator\Magento\Model\Validator\ModuleValidator;
use Marsskom\Generator\Magento\Model\Validator\NameValidator;
use Marsskom\Generator\Magento\Model\Validator\PropertiesValidator;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class EntityCommand extends GeneratorCommand
{
    /**
     * @inheritdoc
     */
    protected function configure(): void
    {
        $this->setName('generate:entity');
        $this->setDescription("Generates entity.");

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
                'Model'
            ),
            new InputOption(
                InputParameter::NAME,
                null,
                InputOption::VALUE_REQUIRED,
                'Class name'
            ),
            PropertiesOption::create(),
            new InputOption(
                'i',
                null,
                InputOption::VALUE_OPTIONAL,
                'Indicates whether to create an interface for class',
                false
            ),
            new InputOption(
                'do',
                null,
                InputOption::VALUE_OPTIONAL,
                'Indicates whether tha class extends DataObject',
                false
            ),
        ]);
    }

    /**
     * @inheritdoc
     */
    protected function flow(): FlowInterface
    {
        $pipeline = [
            static fn($c, $i) => $c
                ->set(TemplateVariable::MODULE_NAME, $i->get(InputParameter::MODULE))
                ->set(TemplateVariable::CLASS_NAME, $i->get(InputParameter::NAME)),
            new NamespaceCallable(),
            new PropertiesCallable(),
            new MethodCallable(),
        ];

        return $this->flowFactory
            ->create()
            ->validator([
                new ModuleValidator(),
                new NameValidator(),
                new PropertiesValidator(),
            ])
            ->with('interface', [
                [
                    // Condition
                    static function ($i): void {
                        if (empty($i->get('i'))) {
                            throw new ConditionFailedException("Skip interface creation.");
                        }
                    },
                    static fn($c, $i) => $c
                        ->set(TemplateVariable::INTERFACE_NAME, $i->get(InputParameter::NAME) . 'Interface'),
                    ...$pipeline,
                    static fn($c, $i) => $c->set(ContextVariable::FILENAME_VALUE, new FileName(
                        'Api/Data/%path%/%name%Interface.php',
                        [
                            '%path%' => rtrim($i->get(InputParameter::PATH), '/'),
                            '%name%' => $i->get(InputParameter::NAME),
                        ]
                    )),
                    // Overrides namespace
                    new NamespaceCallable(),
                    static function ($s, $c): ContextInterface {
                        $interfaceNamespace = $c->get(TemplateVariable::FILE_NAMESPACE)
                            . '\\' . $c->get(TemplateVariable::INTERFACE_NAME);

                        return $s
                            ->use('default')
                            ->add(TemplateVariable::FILE_USES, 'use ' . $interfaceNamespace . ';')
                            ->add(TemplateVariable::CLASS_IMPLEMENTS, $c->get(TemplateVariable::INTERFACE_NAME));
                    },
                    static fn($c, $i) => $c->set(
                        ContextVariable::BOUNDED_VALUE,
                        new Param('entity/interface.stub', $c->getAll())
                    ),
                ],
            ])
            ->with('default', [
                ...$pipeline,
                [
                    // Condition
                    static function ($i): void {
                        if (empty($i->get('do'))) {
                            throw new ConditionFailedException("Skip DataObject extends.");
                        }
                    },
                    static fn($c) => $c
                        ->add(TemplateVariable::FILE_USES, 'use Magento\Framework\DataObject;')
                        ->add(TemplateVariable::CLASS_EXTENDS, 'DataObject'),
                ],
                static fn($c, $i) => $c->set(ContextVariable::FILENAME_VALUE, new FileName(
                    '%path%/%name%.php',
                    [
                        '%path%' => rtrim($i->get(InputParameter::PATH), '/'),
                        '%name%' => $i->get(InputParameter::NAME),
                    ]
                )),
                static fn($c, $i) => $c->set(
                    ContextVariable::BOUNDED_VALUE,
                    new Param('entity/entity.stub', $c->getAll())
                ),
            ]);
    }
}
