<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Sequence;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class SimpleGenerator extends AbstractSequence
{
    private string $value;

    /**
     * @inheritdoc
     *
     * @param string $value
     */
    public function __construct(
        string $value,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $variables = $context->getVariables();
        $variables[] = $this->value;

        return $context->setVariables($variables);
    }
}
