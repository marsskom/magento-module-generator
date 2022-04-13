<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console\Base;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;
use Marsskom\Generator\Helper\Translator\PathHelper;
use Marsskom\Generator\Model\Context\Parameters;

class PathTranslator implements InputTranslatorInterface
{
    private PathHelper $pathHelper;

    /**
     * Module translator constructor.
     *
     * @param PathHelper $pathHelper
     */
    public function __construct(
        PathHelper $pathHelper
    ) {
        $this->pathHelper = $pathHelper;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function translate(array $contexts, array $inputOptions): array
    {
        return [
            'path' => [
                'toModule' => $this->pathHelper->getModulePath($inputOptions[Parameters::MODULE]),
                'toFile'   => $this->pathHelper->getPathToFile(
                    $inputOptions[Parameters::MODULE],
                    $inputOptions[Parameters::PATH]
                ),
            ],
        ];
    }
}
