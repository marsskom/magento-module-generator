<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console\Base;

use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;

class ModuleTranslator implements InputTranslatorInterface
{
    /**
     * @inheritdoc
     */
    public function translate(array $contexts, array $inputOptions): array
    {
        if (empty($contexts['module'])) {
            return [];
        }

        return [
            'module' => [
                'name' => $inputOptions['module'],
            ],
        ];
    }
}
