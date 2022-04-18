<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Test\Unit\Mock\Automation;

use Marsskom\Generator\Api\Data\Context\ContextInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class MultiplierGenerator extends AbstractSequence
{
    private int $multiplier;

    public function __construct(
        int $multiplier,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->multiplier = $multiplier;
    }

    /**
     * @inheritdoc
     */
    public function execute(ContextInterface $context): ContextInterface
    {
        $variables = $context->getVariables();
        foreach ($variables as $key => $value) {
            $variables[$key] = $value * $this->multiplier;
        }

        return $context->setVariables($variables);
    }
}
