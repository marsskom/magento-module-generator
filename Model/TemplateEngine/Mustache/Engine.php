<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\TemplateEngine\Mustache;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Template\TemplateInterface;
use Marsskom\Generator\Api\Data\Template\TemplateInterfaceFactory;
use Marsskom\Generator\Api\Data\TemplateEngineInterface;
use Marsskom\Generator\Model\Helper\Stub;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class Engine implements TemplateEngineInterface
{
    private TemplateInterfaceFactory $templateFactory;

    private Stub $stubHelper;

    /**
     * Engine constructor.
     *
     * @param TemplateInterfaceFactory $templateFactory
     * @param Stub                     $stubHelper
     */
    public function __construct(
        TemplateInterfaceFactory $templateFactory,
        Stub $stubHelper
    ) {
        $this->templateFactory = $templateFactory;
        $this->stubHelper = $stubHelper;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function make(string $stubName, array $contextArray): TemplateInterface
    {
        $engine = $this->createMustacheEngine();

        return $this->templateFactory->create([
            'content' => $engine->render($stubName, $contextArray),
        ]);
    }

    /**
     * Creates mustache engine.
     *
     * @return Mustache_Engine
     *
     * @throws FileSystemException
     */
    protected function createMustacheEngine(): Mustache_Engine
    {
        $loaderOptions = [
            'extension' => $this->stubHelper->getExtension(),
        ];

        return new Mustache_Engine([
            'loader'          => new Mustache_Loader_FilesystemLoader(
                $this->stubHelper->pathToStubs(),
                $loaderOptions
            ),
            'partials_loader' => new Mustache_Loader_FilesystemLoader(
                $this->stubHelper->pathToPartials(),
                $loaderOptions
            ),
        ]);
    }
}
