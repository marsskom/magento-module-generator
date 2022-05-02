<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Wrapper;

use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;

class CallableValue
{
    private array $parameters = [];

    private ?ScopeInterface $scope = null;

    /**
     * Returns parameters.
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Sets parameters.
     *
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns scope.
     *
     * @return null|ScopeInterface
     */
    public function getScope(): ?ScopeInterface
    {
        return $this->scope;
    }

    /**
     * Sets scope.
     *
     * @param null|ScopeInterface $scope
     */
    public function setScope(?ScopeInterface $scope): void
    {
        $this->scope = $scope;
    }
}
