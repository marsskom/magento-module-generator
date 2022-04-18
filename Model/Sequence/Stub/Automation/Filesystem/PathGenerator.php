<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Magento\Framework\Exception\FileSystemException;
use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Api\Data\Helper\PathInterface;
use Marsskom\Generator\Model\Enum\InputParameter;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class PathGenerator extends AbstractSequence
{
    private PathInterface $pathHelper;

    /**
     * @inheritdoc
     *
     * @param PathInterface $pathHelper
     */
    public function __construct(
        PathInterface $pathHelper,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->pathHelper = $pathHelper;
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
                $context->getUserInput()[InputParameter::PATH]
            )
        );
    }
}
