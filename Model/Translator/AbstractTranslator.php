<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Translator;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Helper\Path;

abstract class AbstractTranslator implements TranslatorInterface
{
    protected Path $pathHelper;

    /**
     * Translator constructor.
     *
     * @param Path $pathHelper
     */
    public function __construct(
        Path $pathHelper
    ) {
        $this->pathHelper = $pathHelper;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function getPath(array $input): string
    {
        return $this->pathHelper->getPathToFile(
            $input[InputParameter::MODULE],
            $input[InputParameter::PATH]
        );
    }

    /**
     * @inheritdoc
     */
    public function getFileName(array $input): string
    {
        return $input[InputParameter::NAME];
    }
}
