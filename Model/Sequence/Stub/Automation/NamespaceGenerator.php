<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;

class NamespaceGenerator extends AbstractSequence
{
    private ModuleBuilder $moduleBuilder;

    /**
     * @inheritdoc
     *
     * @param ModuleBuilder $moduleBuilder
     */
    public function __construct(
        ModuleBuilder $moduleBuilder,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->moduleBuilder = $moduleBuilder;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $variables = $context->getVariables();
        $variables[TemplateVariable::FILE_NAMESPACE] = $this->getNamespace(
            $context->getUserInput()[InputParameter::MODULE],
            $context->getUserInput()[InputParameter::PATH]
        );

        return $context->setVariables($variables);
    }

    /**
     * Returns namespace.
     *
     * @param string $moduleName
     * @param string $path
     *
     * @return string
     */
    protected function getNamespace(string $moduleName, string $path = ''): string
    {
        $module = $this->moduleBuilder->fromMagentoModuleName($moduleName);

        return implode(
            '\\',
            [
                $module->getVendor(),
                $module->getName(),
                str_replace('/', '\\', $path),
            ]
        );
    }
}
