<?php

declare(strict_types = 1);

namespace Marsskom\Generator\Domain\Interfaces\Callables;

use Marsskom\Generator\Domain\Exception\Callables\IsNotCallableException;
use Marsskom\Generator\Domain\Interfaces\Observer\ObserverInterface;

interface CallableBuilderInterface
{
    /**
     * Adds observer into callable.
     *
     * @param string            $eventName
     * @param ObserverInterface $observer
     *
     * @return CallableBuilderInterface
     */
    public function withObserver(string $eventName, ObserverInterface $observer): CallableBuilderInterface;

    /**
     * Builds callbacks pipelines.
     *
     * @param array $callables
     *
     * @return array
     *
     * @throws IsNotCallableException
     */
    public function build(array $callables): array;
}
