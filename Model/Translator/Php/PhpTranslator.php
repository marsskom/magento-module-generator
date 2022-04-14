<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Translator\Php;

use Marsskom\Generator\Api\Data\Translator\TranslatorInterface;
use Marsskom\Generator\Model\Enum\InputParameter;

abstract class PhpTranslator implements TranslatorInterface
{
    /**
     * @inheritdoc
     */
    public function getFileName(array $input): string
    {
        return $input[InputParameter::NAME] . '.php';
    }
}
