<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Foundation;

use Marsskom\Generator\Api\Data\Generator\StubGeneratorInterface;
use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Api\Data\TemplateEngineInterfaceFactory;

abstract class StubGenerator extends AbstractSequence implements StubGeneratorInterface
{
    private TemplateEngineInterfaceFactory $templateFactory;

    /**
     * @inheritdoc
     *
     * @param TemplateEngineInterfaceFactory $tplEngineFactory
     */
    public function __construct(
        TemplateEngineInterfaceFactory $tplEngineFactory,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->templateFactory = $tplEngineFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $templateEngine = $this->templateFactory->create();

        $template = $templateEngine->make(
            $this->getStubName(),
            $scope->var()->getAll()
        );

        $scope->context()->setTemplate($template);

        return $scope;
    }
}
