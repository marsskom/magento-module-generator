<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Helper;

use Magento\Framework\Exception\FileSystemException;
use function implode;
use const DIRECTORY_SEPARATOR;

class Stub
{
    public const MODULE_NAME = 'Marsskom_Generator';

    private Path $pathHelper;

    private string $directory;

    private string $partials;

    private string $extension;

    /**
     * Stub helper constructor.
     *
     * @param Path   $pathHelper
     * @param string $directory
     * @param string $partials
     * @param string $extension
     */
    public function __construct(
        Path $pathHelper,
        string $directory = 'stubs',
        string $partials = 'partials',
        string $extension = '.stub'
    ) {
        $this->pathHelper = $pathHelper;
        $this->directory = $directory;
        $this->partials = $partials;
        $this->extension = $extension;
    }

    /**
     * Returns path to stubs.
     *
     * @return string
     * @throws FileSystemException
     */
    public function pathToStubs(): string
    {
        return $this->pathHelper->getPathToFile(
            self::MODULE_NAME,
            $this->directory
        );
    }

    /**
     * Returns path to partials stubs.
     *
     * @return string
     * @throws FileSystemException
     */
    public function pathToPartials(): string
    {
        return $this->pathHelper->getPathToFile(
            self::MODULE_NAME,
            implode(
                DIRECTORY_SEPARATOR,
                [
                    $this->directory,
                    $this->partials,
                ]
            )
        );
    }

    /**
     * Returns stub extension.
     *
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }
}
