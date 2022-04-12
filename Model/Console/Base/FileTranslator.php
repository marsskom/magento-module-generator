<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console\Base;

use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;

class FileTranslator implements InputTranslatorInterface
{
    /**
     * @inheritdoc
     */
    public function translate(array $contexts, array $inputOptions): array
    {
        if (empty($contexts['file'])) {
            return [];
        }

        return [
            'file' => [
                'name'      => $inputOptions['name'],
                'extension' => 'php',
                'path'      => null,
            ],
        ];
    }
}
