<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Model\Scope;

use Marsskom\Generator\Api\Data\Scope\ScopeVariableInterface;

class ScopeVariableBuilder
{
    private ScopeVariableFactory $scopeVariableFactory;

    /**
     * Scope variable builder constructor.
     *
     * @param ScopeVariableFactory $scopeVariableFactory
     */
    public function __construct(
        ScopeVariableFactory $scopeVariableFactory
    ) {
        $this->scopeVariableFactory = $scopeVariableFactory;
    }

    /**
     * Creates scope variable.
     *
     * @return ScopeVariableInterface
     */
    public function create(): ScopeVariableInterface
    {
        return $this->scopeVariableFactory->create();
    }
}
