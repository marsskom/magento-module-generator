<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation\Filesystem;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class FileNameAssigner extends AbstractSequence
{
    private string $fileName;

    /**
     * @inheritdoc
     *
     * @param string $name
     */
    public function __construct(
        string $name,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->fileName = $name;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        return $context->setFileName($this->fileName);
    }
}
