<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use Marsskom\Generator\Model\Helper\Path;

class PathAssigner extends AbstractSequence
{
    private Path $pathHelper;

    private string $path;

    private bool $isAbsolute;

    /**
     * @inheritdoc
     *
     * @param Path   $pathHelper
     * @param string $path
     * @param bool   $isAbsolute - true if path is calculated from generated module
     *                           without usage user input into variable `path`
     */
    public function __construct(
        Path $pathHelper,
        string $path = '',
        bool $isAbsolute = false,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->pathHelper = $pathHelper;
        $this->path = $path;
        $this->isAbsolute = $isAbsolute;
    }

    /**
     * @inheritDoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        return $context->setPath(
            $this->pathHelper->getPathToFile(
                $context->getUserInput()[InputParameter::MODULE],
                $this->getPath($context)
            )
        );
    }

    /**
     * Returns generated path.
     *
     * @param ContextInterface $context
     *
     * @return string
     */
    protected function getPath(ContextInterface $context): string
    {
        if ($this->isAbsolute) {
            return $this->path;
        }

        return $context->getUserInput()[InputParameter::PATH] . DIRECTORY_SEPARATOR . $this->path;
    }
}
