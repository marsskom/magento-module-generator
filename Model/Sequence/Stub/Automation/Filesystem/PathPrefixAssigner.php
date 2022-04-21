<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Helper\PathInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;
use const DIRECTORY_SEPARATOR;

class PathPrefixAssigner extends AbstractSequence
{
    private PathInterface $pathHelper;

    private string $prefix;

    /**
     * @inheritdoc
     *
     * @param PathInterface $pathHelper
     * @param string        $prefix
     */
    public function __construct(
        PathInterface $pathHelper,
        string $prefix = '',
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->pathHelper = $pathHelper;
        $this->prefix = $prefix;
    }

    /**
     * @inheritdoc
     *
     * @throws FileSystemException
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        return $context->setPath(
            $this->pathHelper->getPathToFile(
                $context->getUserInput()[InputParameter::MODULE],
                $this->prefix . DIRECTORY_SEPARATOR . $context->getUserInput()[InputParameter::PATH]
            )
        );
    }
}
