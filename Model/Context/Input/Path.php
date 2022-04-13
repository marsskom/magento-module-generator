<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Context\Input;

use Marsskom\Generator\Api\Data\Context\Input\PathInterface;

class Path implements PathInterface
{
    private string $toModule;

    private string $toFile;

    /**
     * Path model constructor.
     *
     * @param string $toModule
     * @param string $toFile
     */
    public function __construct(
        string $toModule,
        string $toFile
    ) {
        $this->toModule = $toModule;
        $this->toFile = $toFile;
    }

    /**
     * @inheritdoc
     */
    public function toModule(): string
    {
        return $this->toModule;
    }

    /**
     * @inheritdoc
     */
    public function toFile(): string
    {
        return $this->toFile;
    }
}
