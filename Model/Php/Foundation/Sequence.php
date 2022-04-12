<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Php\Foundation;

use Marsskom\Generator\Api\Data\ContextInterface;

class Sequence extends AbstractSequence
{
    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        foreach ($this->children as $child) {
            $child->execute($context);
        }

        return $context;
    }
}
