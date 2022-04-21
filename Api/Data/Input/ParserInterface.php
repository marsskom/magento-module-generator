<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data\Input;

interface ParserInterface
{
    /**
     * Parses input value and return a result.
     *
     * @param string $inputValue
     *
     * @return mixed
     */
    public function parse(string $inputValue);
}
