<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Sequence;

use Marsskom\Generator\Model\Foundation\Sequence;
use Marsskom\Generator\Test\Unit\Mock\Automation\WriterIntoTemplateFromArray;
use function array_merge;
use function str_split;

class SimpleSequence extends Sequence
{
    public function __construct(
        string $value,
        array $sequences = []
    ) {
        $generators = [];
        foreach (str_split($value) as $v) {
            $generators[] = new SimpleGenerator($v);
        }

        $sequences = array_merge($generators, $sequences);

        $sequences[] = new WriterIntoTemplateFromArray();

        parent::__construct($sequences);
    }
}
