<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Api\Data;

interface SequenceInterface extends GeneratorInterface
{
    /**
     * Sets parent sequence for current.
     * 
     * @param SequenceInterface $parent
     *
     * @return SequenceInterface
     */
    public function setParent(SequenceInterface $parent): SequenceInterface;

    /**
     * Returns parent sequence.
     * 
     * @return null|SequenceInterface
     */
    public function getParent(): ?SequenceInterface;

    /**
     * Adds sequence to children of current.
     * 
     * @param SequenceInterface $sequence
     *
     * @return SequenceInterface
     */
    public function add(SequenceInterface $sequence): SequenceInterface;
}
