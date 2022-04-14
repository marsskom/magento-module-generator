<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Builder;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\OutputInterface;
use Marsskom\Generator\Api\Data\Context\OutputInterfaceFactory;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Helper\Path;

class OutputBuilder
{
    private OutputInterfaceFactory $outputFactory;

    private Path $pathHelper;

    /**
     * Output builder constructor.
     *
     * @param OutputInterfaceFactory $outputFactory
     * @param Path                   $pathHelper
     */
    public function __construct(
        OutputInterfaceFactory $outputFactory,
        Path $pathHelper
    ) {
        $this->outputFactory = $outputFactory;
        $this->pathHelper = $pathHelper;
    }

    /**
     * Creates output context.
     *
     * @param array               $userInput
     * @param TranslatorInterface $translator
     *
     * @return OutputInterface
     * @throws FileSystemException
     */
    public function create(array $userInput, TranslatorInterface $translator): OutputInterface
    {
        return $this->outputFactory->create([
            'path'     => $this->pathHelper->getPathToFile(
                $userInput[InputParameter::MODULE],
                $userInput[InputParameter::PATH]
            ),
            'fileName' => $translator->getFileName($userInput),
        ]);
    }
}
