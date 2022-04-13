<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Foundation;

use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Api\Data\GeneratorInterface;
use Marsskom\Generator\Api\Data\SequenceInterface;
use Marsskom\Generator\Model\Helper\SeparatedFactory;

class Sequence extends AbstractSequence
{
    private SeparatedFactory $factory;

    /**
     * Sequence constructor.
     *
     * @param SeparatedFactory          $factory
     * @param array<SequenceInterface>  $sequences
     * @param array<GeneratorInterface> $nextMiddlewares
     */
    public function __construct(
        SeparatedFactory $factory,
        array $sequences = [],
        array $nextMiddlewares = []
    ) {
        parent::__construct($sequences, $nextMiddlewares);

        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $separator = $this->factory->create();

        foreach ($this->children as $child) {
            // Common method.
            $context = $child->execute($context);

            // Middleware generators - horizontal level.
            $next = $child->next();
            while (null !== $next) {
                $context = $next->execute($context);
                $next = $next->next();
            }

            // Separator collects all contents.
            $separator->addContent(
                $context->output()->asString()
            );
            // Separator becomes as state object.
            $context->output()->setState($separator);
        }

        return $context;
    }
}
