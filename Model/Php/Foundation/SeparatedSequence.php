<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Foundation;

use Marsskom\Generator\Api\Data\ContextInterface;
use Marsskom\Generator\Model\Helper\SeparatedFactory;

class SeparatedSequence extends AbstractSequence
{
    private SeparatedFactory $factory;

    /**
     * Sequence constructor.
     *
     * @param SeparatedFactory $factory
     * @param array            $sequences
     */
    public function __construct(
        SeparatedFactory $factory,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $separator = $this->factory->create();

        foreach ($this->children as $child) {
            $child->execute($context);

            $separator->add($context->output()->asString());
        }

        $context->output()->setState($separator);

        return $context;
    }
}
