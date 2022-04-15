<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Foundation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;

class Sequence extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        foreach ($this->children as $child) {
            $context = $child->execute($context);
        }

        return $context;
    }
}
