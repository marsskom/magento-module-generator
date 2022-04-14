<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Builder;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Context\ContextInterfaceFactory;
use Marsskom\Generator\Api\Data\Context\InputInterfaceFactory;
use Marsskom\Generator\Api\Data\Context\OutputInterfaceFactory;

class ContextBuilder
{
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
     * Creates context.
     *
     * @param array $inputData
     * @param array $outputData
     *
     * @return ContextInterface
     */
    public function create(array $inputData, array $outputData): ContextInterface
    {
        return $this->contextFactory->create([
            'input'  => $this->inputFactory->create($inputData),
            'output' => $this->outputFactory->create($outputData),
        ]);
    }
}
