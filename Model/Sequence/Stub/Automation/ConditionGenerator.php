<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Sequence\Stub\Automation;

use Marsskom\Generator\Api\Data\Scope\ScopeInterface;
use Marsskom\Generator\Model\Foundation\Sequence;

class ConditionGenerator extends Sequence
{
    /**
     * Closure for `call_user_func`.
     *
     * @var callable|Closure|mixed
     */
    private $callback;

    /**
     * @inheritdoc
     *
     * @param null|mixed|callable $callback
     */
    public function __construct(
        $callback,
        array $sequences = []
    ) {
        parent::__construct($sequences);

        $this->callback = $callback;
    }

    /**
     * @inheritdoc
     */
    public function execute(ScopeInterface $scope): ScopeInterface
    {
        // @codingStandardsIgnoreLine
        if (!call_user_func($this->callback, $scope)) {
            return $scope;
        }

        return parent::execute($scope);
    }
}
