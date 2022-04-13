<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Console\Base;

use Marsskom\Generator\Api\Data\Context\InputTranslatorInterface;
use Marsskom\Generator\Model\Context\Parameters;

class ClassTranslator implements InputTranslatorInterface
{
    /**
     * @inheritdoc
     */
    public function translate(array $contexts, array $inputOptions): array
    {
        if (empty($contexts['class'])) {
            return [];
        }

        return [
            'class' => [
                'name'       => $inputOptions[Parameters::NAME],
                'namespace'  => null,
                'extends'    => '',
                'implements' => [],
                'comments'   => [],
            ],
        ];
    }
}
