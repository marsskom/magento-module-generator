<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Foundation;

use Marsskom\Generator\Api\Data\GeneratorInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use SplQueue;

abstract class AbstractSequence implements SequenceInterface
{
    protected ?SequenceInterface $parent;

    /**
     * @var SplQueue<SequenceInterface>
     */
    protected SplQueue $children;

    protected ?GeneratorInterface $nextMiddleware = null;

    /**
     * Sequence constructor.
     *
     * @param array<SequenceInterface>                 $sequences
     * @param array<string, array<GeneratorInterface>> $nextMiddlewares
     */
    public function __construct(
        array $sequences = [],
        array $nextMiddlewares = []
    ) {
        foreach ($nextMiddlewares as $sequenceName => $middlewares) {
            if (!isset($sequences[$sequenceName])) {
                continue;
            }

            $current = $sequences[$sequenceName];
            foreach ($middlewares as $middleware) {
                $current->setNextMiddleware($middleware);
                $current = $middleware;
            }
        }

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

    /**
     * @inheritdoc
     */
    public function setNextMiddleware(GeneratorInterface $middleware): void
    {
        $this->nextMiddleware = $middleware;
    }

    /**
     * @inheritdoc
     */
    public function next(): ?GeneratorInterface
    {
        return $this->nextMiddleware;
    }
}
