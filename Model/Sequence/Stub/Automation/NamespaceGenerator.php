<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Helper\PathInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Enum\TemplateVariable;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\Helper\Builder\ModuleBuilder;
use function str_replace;

class NamespaceGenerator extends AbstractSequence
{
    private PathInterface $pathHelper;

    private ModuleBuilder $moduleBuilder;

    /**
     * @inheritdoc
     *
     * @param PathInterface $pathHelper
     * @param ModuleBuilder $moduleBuilder
     */
    public function __construct(
        PathInterface $pathHelper,
        ModuleBuilder $moduleBuilder,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->pathHelper = $pathHelper;
        $this->moduleBuilder = $moduleBuilder;
    }

    /**
     * @inheritdoc
     *
     * @throws LocalizedException
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $moduleName = $context->getUserInput()[InputParameter::MODULE];
        $path = $context->getUserInput()[InputParameter::PATH];

        if (!empty($context->getPath())) {
            $modulePath = $this->pathHelper->getModulePath($moduleName);
            $path = str_replace($modulePath, '', $context->getPath());
        }

        $namespace = $this->getNamespace($moduleName, $path);

        $variables = $context->getVariables();
        $variables[TemplateVariable::FILE_NAMESPACE] = str_replace('\\\\', '\\', $namespace);

        return $context->setVariables($variables);
    }

    /**
     * Returns namespace.
     *
     * @param string $moduleName
     * @param string $path
     *
     * @return string
     *
     * @throws LocalizedException
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
