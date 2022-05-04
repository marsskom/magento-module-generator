<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Infrastructure\Model\Filesystem;

use Marsskom\Generator\Domain\Interfaces\ValueObjectInterface;
use function strtr;

class FileName implements ValueObjectInterface
{
    private string $fileName;

    private array $options;

    /**
     * File name constructor.
     *
     * @param string $fileName
     * @param array  $options
     */
    public function __construct(string $fileName, array $options = [])
    {
        $this->fileName = $fileName;
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function value()
    {
        return strtr($this->fileName, $this->options);
    }

    /**
     * To string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
