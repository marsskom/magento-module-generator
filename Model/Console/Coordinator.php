<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console;

use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Api\Data\CoordinatorInterface;
use Marsskom\Generator\Api\Data\TranslatorInterface;
use Marsskom\Generator\Model\Context;
use Marsskom\Generator\Model\Context\OutputFactory;
use Marsskom\Generator\Model\ContextFactory;

class Coordinator implements CoordinatorInterface
{
    private Context $context;

    private ContextFactory $contextFactory;

    private OutputFactory $outputFactory;

    private TranslatorInterface $translator;

    private array $inputOptions;

    private array $inputTranslators;

    /**
     * Coordinator constructor.
     *
     * @param ContextFactory      $contextFactory
     * @param OutputFactory       $outputFactory
     * @param TranslatorInterface $translator
     * @param array               $inputOptions
     * @param array               $inputTranslators
     */
    public function __construct(
        ContextFactory $contextFactory,
        OutputFactory $outputFactory,
        TranslatorInterface $translator,
        array $inputOptions,
        array $inputTranslators = []
    ) {
        $this->contextFactory = $contextFactory;
        $this->outputFactory = $outputFactory;
        $this->translator = $translator;
        $this->inputOptions = $inputOptions;
        $this->inputTranslators = $inputTranslators;
    }

    /**
     * @inheritdoc
     */
    public function create(): CoordinatorInterface
    {
        $this->context = $this->contextFactory->create([
            'input'  => $this->translator
                ->addInputTranslators($this->inputTranslators)
                ->translate($this->inputOptions),
            'output' => $this->outputFactory->create(),
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function get(): ContextInterface
    {
        return $this->context;
    }
}
