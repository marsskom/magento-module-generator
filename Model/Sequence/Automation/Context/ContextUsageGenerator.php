<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Automation\Context;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\AbstractSequence;

class ContextUsageGenerator extends AbstractSequence
{
    private string $contextAlias;

    /**
     * @inheritdoc
     *
     * @param string $contextAlias
     */
    public function __construct(
        string $contextAlias = '',
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->contextAlias = $contextAlias;
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        return $scope->setCurrentContextFromAlias($this->contextAlias);
    }
}
