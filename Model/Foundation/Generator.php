<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Foundation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\TemplateEngineInterfaceFactory;

class Generator extends AbstractSequence
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
            $context->input()->getStubName(),
            $context->input()->toArray()
        );

        $context->output()->set($template);

        return $context;
    }
}
