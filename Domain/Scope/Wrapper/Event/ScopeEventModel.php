<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Scope\Wrapper\Event;

use Marsskom\Generator\Domain\Interfaces\Scope\ScopeInterface;

class ScopeEventModel
{
    private ScopeInterface $scope;

    private $result;

    /**
     * Event model constructor.
     *
     * @param ScopeInterface $scope
     * @param mixed          $result
     */
    public function __construct(ScopeInterface $scope, $result)
    {
        $this->scope = $scope;
        $this->result = $result;
    }

    /**
     * Returns scope.
     *
     * @return ScopeInterface
     */
    public function scope(): ScopeInterface
    {
        return $this->scope;
    }

    /**
     * Returns callable result.
     *
     * @return mixed
     */
    public function result()
    {
        return $this->result;
    }
}
