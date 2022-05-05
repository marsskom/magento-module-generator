<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\TemplateEngine\Mustache;

use Magento\Framework\Exception\LocalizedException;
use Marsskom\Generator\Infrastructure\Api\Data\TemplateEngineInterface;
use Marsskom\Generator\Infrastructure\Api\Data\TemplateInterface;
use Marsskom\Generator\Infrastructure\Api\Data\TemplateInterfaceFactory;
use Marsskom\Generator\Infrastructure\Api\PathInterface;
use Marsskom\Generator\Magento\Model\Helper\Builder\ModuleBuilder;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class Engine implements TemplateEngineInterface
{
    private PathInterface $path;

    private TemplateInterfaceFactory $factory;

    /**
     * Engine constructor.
     *
     * @param PathInterface            $path
     * @param TemplateInterfaceFactory $factory
     */
    public function __construct(
        PathInterface $path,
        TemplateInterfaceFactory $factory
    ) {
        $this->path = $path;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     *
     * @throws LocalizedException
     */
    public function make(object $params): TemplateInterface
    {
        /** @var $params Param */

        $engine = $this->createMustacheEngine();

        return $this->factory->create([
            'content' => $engine->render(
                $params->stubName(),
                $params->variables()
            ),
        ]);
    }

    /**
     * Creates mustache engine.
     *
     * @return Mustache_Engine
     *
     * @throws LocalizedException
     */
    protected function createMustacheEngine(): Mustache_Engine
    {
        $module = (new ModuleBuilder())->fromMagentoModuleName('Marsskom_Generator');

        $loaderOptions = [
            'extension' => '.stub',
        ];

        return new Mustache_Engine([
            'loader'          => new Mustache_Loader_FilesystemLoader(
                $this->path->path($module, 'stubs'),
                $loaderOptions
            ),
            'partials_loader' => new Mustache_Loader_FilesystemLoader(
                $this->path->path($module, 'stubs/partials'),
                $loaderOptions
            ),
        ]);
    }
}
