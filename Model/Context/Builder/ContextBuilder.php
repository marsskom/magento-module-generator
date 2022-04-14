<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Builder;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterfaceFactory;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;

class ContextBuilder
{
    private ContextInterfaceFactory $contextFactory;

    private InputBuilder $inputBuilder;

    private OutputBuilder $outputBuilder;

    /**
     * Coordinator constructor.
     *
     * @param ContextInterfaceFactory $contextFactory
     * @param InputBuilder            $inputBuilder
     * @param OutputBuilder           $outputBuilder
     */
    public function __construct(
        ContextInterfaceFactory $contextFactory,
        InputBuilder $inputBuilder,
        OutputBuilder $outputBuilder
    ) {
        $this->contextFactory = $contextFactory;
        $this->inputBuilder = $inputBuilder;
        $this->outputBuilder = $outputBuilder;
    }

    /**
     * Creates context.
     *
     * @param array               $userInput
     * @param TranslatorInterface $translator
     *
     * @return ContextInterface
     *
     * @throws FileSystemException
     */
    public function create(array $userInput, TranslatorInterface $translator): ContextInterface
    {
        return $this->contextFactory->create([
            'input'  => $this->inputBuilder->create($userInput, $translator),
            'output' => $this->outputBuilder->create($userInput, $translator),
        ]);
    }
}
