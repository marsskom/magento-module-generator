<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterfaceFactory;
use Marsskom\Generator\Api\Data\Context\InputInterfaceFactory;
use Marsskom\Generator\Api\Data\Context\OutputInterfaceFactory;
use Marsskom\Generator\Api\Data\CoordinatorInterface;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;

class Coordinator implements CoordinatorInterface
{
    /**
     * @var array<string, string>
     */
    private array $input = [];

    private TranslatorInterface $translator;

    private ContextInterfaceFactory $contextFactory;

    private InputInterfaceFactory $inputFactory;

    private OutputInterfaceFactory $outputFactory;

    /**
     * Coordinator constructor.
     *
     * @param ContextInterfaceFactory $contextFactory
     * @param InputInterfaceFactory   $inputFactory
     * @param OutputInterfaceFactory  $outputFactory
     */
    public function __construct(
        ContextInterfaceFactory $contextFactory,
        InputInterfaceFactory $inputFactory,
        OutputInterfaceFactory $outputFactory
    ) {
        $this->contextFactory = $contextFactory;
        $this->inputFactory = $inputFactory;
        $this->outputFactory = $outputFactory;
    }

    /**
     * @inheritdoc
     */
    public function setInput(array $input): CoordinatorInterface
    {
        $this->input = $input;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTranslator(TranslatorInterface $translator): CoordinatorInterface
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContext(): ContextInterface
    {
        return $this->contextFactory->create([
            'input'  => $this->inputFactory->create([
                'stubName'    => $this->translator->getStubName($this->input),
                'stubClasses' => $this->translator->translate($this->input),
            ]),
            'output' => $this->outputFactory->create([
                'path'     => $this->translator->getPath($this->input),
                'fileName' => $this->translator->getFileName($this->input),
            ]),
        ]);
    }
}
