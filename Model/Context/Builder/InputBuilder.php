<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Builder;

use Marsskom\Generator\Api\Data\Context\InputInterface;
use Marsskom\Generator\Api\Data\Context\InputInterfaceFactory;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;

class InputBuilder
{
    private InputInterfaceFactory $inputFactory;

    /**
     * Input builder constructor.
     *
     * @param InputInterfaceFactory $inputFactory
     */
    public function __construct(
        InputInterfaceFactory $inputFactory
    ) {
        $this->inputFactory = $inputFactory;
    }

    /**
     * Creates input context.
     *
     * @param array               $userInput
     * @param TranslatorInterface $translator
     *
     * @return InputInterface
     */
    public function create(array $userInput, TranslatorInterface $translator): InputInterface
    {
        return $this->inputFactory->create([
            'stubName'  => $translator->getStubName($userInput),
            'variables' => $translator->translate($userInput),
        ]);
    }
}
