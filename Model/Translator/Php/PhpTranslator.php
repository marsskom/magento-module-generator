<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Translator\Php;

use Marsskom\Generator\Model\Translator\AbstractTranslator;

abstract class PhpTranslator extends AbstractTranslator
{
    /**
     * @inheritdoc
     */
    public function getFileName(array $input): string
    {
        return parent::getFileName($input) . '.php';
    }
}
