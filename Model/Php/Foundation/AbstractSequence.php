<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Foundation;

use Marsskom\Generator\Api\Data\SequenceInterface;
use SplQueue;

abstract class AbstractSequence implements SequenceInterface
{
    protected ?SequenceInterface $parent;

    /**
     * @var SplQueue<SequenceInterface>
     */
    protected SplQueue $children;

    /**
     * Sequence constructor.
     *
     * @param array<SequenceInterface> $sequences
     */
    public function __construct(
        array $sequences = []
    ) {
        $this->children = new SplQueue();

        foreach ($sequences as $sequence) {
            $this->add($sequence);
        }
    }

    /**
     * @inheritdoc
     */
    public function setParent(SequenceInterface $parent): SequenceInterface
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getParent(): ?SequenceInterface
    {
        return $this->parent;
    }

    /**
     * @inheritdoc
     */
    public function add(SequenceInterface $sequence): SequenceInterface
    {
        $sequence->setParent($this);

        $this->children->push($sequence);

        return $this;
    }
}
