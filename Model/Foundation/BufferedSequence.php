<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Foundation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Context\BufferBuilder;

class BufferedSequence extends Sequence
{
    private BufferBuilder $bufferBuilder;

    /**
     * Buffered sequence constructor.
     *
     * @param BufferBuilder $bufferBuilder
     * @param array         $sequences
     */
    public function __construct(
        BufferBuilder $bufferBuilder,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->bufferBuilder = $bufferBuilder;
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        $buffer = $this->bufferBuilder->create($scope);

        parent::execute($scope);

        return $buffer->restore();
    }
}
