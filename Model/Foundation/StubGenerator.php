<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Foundation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Generator\StubGeneratorInterface;
use Marsskom\Generator\Api\Data\TemplateEngineInterfaceFactory;

abstract class StubGenerator extends AbstractSequence implements StubGeneratorInterface
{
    private TemplateEngineInterfaceFactory $templateFactory;

    /**
     * @inheritdoc
     *
     * @param TemplateEngineInterfaceFactory $templateFactory
     */
    public function __construct(
        TemplateEngineInterfaceFactory $templateFactory,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->templateFactory = $templateFactory;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $templateEngine = $this->templateFactory->create([
            'context' => $context,
        ]);

        $template = $templateEngine->make(
            $this->getStubName(),
            $context->getVariables()
        );

        $context->setTemplate($template);

        return $context;
    }
}
